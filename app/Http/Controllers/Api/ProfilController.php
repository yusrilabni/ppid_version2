<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\Position;
use App\Models\Organization;
use App\Models\Informasi;
use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function showOfficial($slug)
    {
        $specialPositions = [
            'bupati' => 'bupati-sinjai',
            'wakil-bupati' => 'wakil-bupati-sinjai',
            'sekretaris-daerah' => 'sekretaris-daerah-sinjai'
        ];
        
        $icon = 'user';

        if (array_key_exists($slug, $specialPositions) || in_array($slug, $specialPositions)) {
            $positionSlug = $specialPositions[$slug] ?? $slug;

            $isPenjabatSlug = str_starts_with($positionSlug, 'penjabat-');
            if ($isPenjabatSlug) {
                $mainPositionSlug = substr($positionSlug, strlen('penjabat-'));
                $penjabatPositionSlug = $positionSlug;
            } else {
                $mainPositionSlug = $positionSlug;
                $penjabatPositionSlug = 'penjabat-' . $positionSlug;
            }

            $mainPosition = Position::where('slug', $mainPositionSlug)->first();
            $penjabatPosition = Position::where('slug', $penjabatPositionSlug)->first();

            $positionIds = [];
            if ($mainPosition) $positionIds[] = $mainPosition->id;
            if ($penjabatPosition) $positionIds[] = $penjabatPosition->id;

            if (empty($positionIds)) {
                return response()->json(['message' => 'Position not found'], 404);
            }

            $official = Official::whereIn('position_id', $positionIds)
                              ->where('status', 'active')
                              ->with(['position', 'organization', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories'])
                              ->first();
        } else {
            $official = Official::where('slug', $slug)
                              ->where('status', 'active')
                              ->with(['position', 'organization', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories'])
                              ->first();

            if (!$official) {
                $organization = Organization::where('slug', $slug)->first();
                if ($organization) {
                    $position = Position::where('slug', 'kepala-opd')->first();
                    if ($position) {
                        $official = Official::where('position_id', $position->id)
                                          ->where('organization_id', $organization->id)
                                          ->where('status', 'active')
                                          ->with(['position', 'organization', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories'])
                                          ->first();
                    }
                }
            }
        }

        if (!$official) {
            return response()->json(['message' => 'Official not found', 'slug' => $slug], 404);
        }

        $menus = config('menu');
        foreach ($menus as $menu) {
            if ($menu['title'] === 'Profil' && !empty($menu['children'])) {
                foreach ($menu['children'] as $child) {
                    $urlPath = parse_url($child['url'], PHP_URL_PATH);
                    $urlSlug = last(explode('/', trim($urlPath, '/')));
                    
                    if (str_contains($slug, $urlSlug) || str_contains($urlSlug, $slug)) {
                        $icon = $child['icon'];
                        break 2;
                    }
                }
            }
        }

        return response()->json([
            'official' => $official,
            'icon' => $icon
        ]);
    }


    public function listKepalaOpd(Request $request)
    {
        $position = Position::where('slug', 'kepala-opd')->first();

        if (!$position) {
            return response()->json(['message' => 'Posisi Kepala OPD tidak ditemukan.'], 404);
        }

        $query = Official::where('position_id', $position->id)
                         ->with(['position', 'organization']);

        $user = $request->user('sanctum');
        if (!$user || ($user && !$user->isAdmin())) { 
            // Untuk publik/user biasa: Hanya tampilkan yang berstatus aktif
            $query->where('status', 'active');
        }
                         
        $kepalaOpdsRaw = $query->orderBy('full_name')->get();
        
        $filteredOpds = $kepalaOpdsRaw->filter(function($official) {
            $orgNameLower = strtolower($official->organization->name ?? '');
            if (str_contains($orgNameLower, 'desa') || str_contains($orgNameLower, 'kelurahan')) {
                return false; // Abaikan Desa dan Kelurahan dari Pejabat Daerah
            }
            return true;
        });

        $kepalaOpds = $filteredOpds->groupBy(function($official) {
            $orgNameLower = strtolower($official->organization->name ?? '');
            if (str_contains($orgNameLower, 'kecamatan')) {
                return 'eselon3';
            }
            return 'eselon2';
        });

        return response()->json([
            'kepalaOpds' => $kepalaOpds,
        ]);
    }

    public function opdList()
    {
        $organizations = Organization::with(['strukturOrganisasi.informasi', 'officials' => function($query) {
            $query->where('status', 'active');
        }])->get();
        $unitData = collect(GeneralHelper::getUnitData());

        $groupedOrganizations = [
            'OPD' => [],
            'Kecamatan' => [],
            'Wilayah (Desa & Kelurahan)' => []
        ];

        $organizations->each(function ($organization) use ($unitData, &$groupedOrganizations) {
            if (stripos($organization->name, 'PEMERINTAH DAERAH') !== false) return;

            $name = $organization->name;
            $matchingUnit = $unitData->get($organization->remote_id);
            $organization->api_address = $matchingUnit['unit_alamat'] ?? 'Alamat belum ditambahkan';
            if (empty($organization->api_address) || $organization->api_address === '0') {
                $organization->api_address = 'Alamat belum ditambahkan';
            }
            $kecamatanName = $matchingUnit['kecamatan'] ?? null;

            if (stripos($name, 'Dinas') !== false || stripos($name, 'Badan') !== false) {
                $groupedOrganizations['OPD'][] = $organization;
            } elseif (stripos($name, 'Kecamatan') !== false) {
                $groupedOrganizations['Kecamatan'][] = $organization;
            } elseif (stripos($name, 'Desa') !== false || stripos($name, 'Kelurahan') !== false) {
                $kecKey = $kecamatanName ?? 'Lainnya';
                if (!isset($groupedOrganizations['Wilayah (Desa & Kelurahan)'][$kecKey])) {
                    $groupedOrganizations['Wilayah (Desa & Kelurahan)'][$kecKey] = [];
                }
                $groupedOrganizations['Wilayah (Desa & Kelurahan)'][$kecKey][] = $organization;
            } else {
                $groupedOrganizations['OPD'][] = $organization;
            }
        });

        if (!empty($groupedOrganizations['Wilayah (Desa & Kelurahan)'])) {
            ksort($groupedOrganizations['Wilayah (Desa & Kelurahan)']);
        }

        $groupedOrganizations = array_filter($groupedOrganizations, fn($group) => count($group) > 0);

        return response()->json([
            'groupedOrganizations' => $groupedOrganizations,
            'organizations' => $organizations // keeping for backward compatibility if needed temporarily
        ]);
    }

    public function opdDetail($slug)
    {
        $organization = Organization::where('slug', $slug)->first();
        if (!$organization) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        $informasi = Informasi::where('content', 'struktur_organisasi_' . $organization->id)->first();
        
        return response()->json([
            'organization' => $organization,
            'informasi' => $informasi
        ]);
    }

    public function unitLokalList(Request $request)
    {
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        
        // Find the 'Kepala OPD' position or similar that is used for Village Heads
        $position = Position::where('slug', 'kepala-opd')->first();
        
        $query = Official::with(['organization', 'position']);
        
        $user = $request->user('sanctum');
        if (!$user || ($user && !$user->isAdmin())) { 
            // Untuk publik/user biasa: Hanya tampilkan yang berstatus aktif
            $query->where('status', 'active');
        }

        // Fetch all officials belonging to Village/Kelurahan organizations
        $allOfficials = $query->get()->filter(function($official) {
            $orgName = $official->organization->name ?? '';
            return stripos($orgName, 'Desa') !== false || stripos($orgName, 'Kelurahan') !== false;
        });

        // Grouping logic
        $groupedData = [];
        
        // Initialize groups for each Kecamatan found in API
        if (!empty($cached['units'])) {
            foreach ($cached['units'] as $unit) {
                if (stripos($unit['unit_nama'], 'Kecamatan') !== false) {
                    $kecName = trim(preg_replace('/\s*Kantor Kecamatan\s*/i', '', $unit['unit_nama']));
                    $groupedData[$kecName] = [
                        'name' => $unit['unit_nama'],
                        'officials' => []
                    ];
                }
            }
        }

        // Fill groups with officials
        foreach ($allOfficials as $official) {
            $unitId = (string)($official->organization->remote_id ?? '');
            $foundGroup = false;

            // Try to find the kecamatan group via API grouping
            if (!empty($cached['villages_grouped'])) {
                foreach ($cached['villages_grouped'] as $kecGroupName => $villages) {
                    foreach ($villages as $v) {
                        if ((string)$v['desa_id'] === $unitId) {
                            $groupedData[$kecGroupName]['officials'][] = $official;
                            $foundGroup = true;
                            break 2;
                        }
                    }
                }
            }

            // Fallback: If not found in API grouping, try ID prefix or Name matching
            if (!$foundGroup) {
                $kecPrefix = substr($unitId, 0, 6);
                $orgName = $official->organization->name ?? '';
                
                foreach ($groupedData as $kecKey => &$group) {
                    // Match by name in parenthesis if exists, e.g., "Desa X (Kec. Bulupoddo)"
                    if (stripos($orgName, $kecKey) !== false) {
                        $group['officials'][] = $official;
                        $foundGroup = true;
                        break;
                    }
                }
            }
            
            // If still not grouped, put in 'Lainnya'
            if (!$foundGroup) {
                $groupedData['Lainnya']['name'] = 'Wilayah Lainnya';
                $groupedData['Lainnya']['officials'][] = $official;
            }
        }

        // Clean up empty groups and sort
        $groupedData = array_filter($groupedData, function($group) {
            return count($group['officials']) > 0;
        });
        ksort($groupedData);

        return response()->json([
            'groupedData' => $groupedData
        ]);
    }
    public function editOfficial(Request $request, $slug)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Anda harus login untuk mengakses ini.'], 403);
        }

        $official = Official::with(['organization', 'position', 'careerHistories', 'educations', 'awards', 'children', 'trainingHistories', 'organizationalHistories'])
            ->where('slug', $slug)->first();
        if (!$official) {
            return response()->json(['message' => 'Pejabat tidak ditemukan.'], 404);
        }

        $hasAccess = false;
        if ($user->isSuperAdmin()) {
            $hasAccess = true;
        }
        if (!$hasAccess && $user->unit_id && isset($official->organization) && (string)$user->unit_id === (string)$official->organization->remote_id) {
            $hasAccess = true;
        }
        if (!$hasAccess && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            $api_unit_id = $apiData['unit_id'] ?? null;
            if (!is_null($api_unit_id) && isset($official->organization) && (string)$api_unit_id === (string)$official->organization->remote_id) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk mengelola pimpinan ini.'], 403);
        }

        return response()->json([
            'success' => true,
            'official' => $official
        ]);
    }

    public function updateOfficial(Request $request, $slug)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Anda harus login untuk mengakses ini.'], 403);
        }

        $official = Official::with('organization')->where('slug', $slug)->first();
        if (!$official) {
            return response()->json(['message' => 'Pejabat tidak ditemukan.'], 404);
        }

        $hasAccess = false;

        // 1. Superadmin
        if ($user->isSuperAdmin()) {
            $hasAccess = true;
        }

        // 2. Cek Unit ID Lokal
        if (!$hasAccess && $user->unit_id && isset($official->organization) && (string)$user->unit_id === (string)$official->organization->remote_id) {
            $hasAccess = true;
        }

        // 3. Cek Unit ID dari API
        if (!$hasAccess && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            $api_unit_id = $apiData['unit_id'] ?? null;
            if (!is_null($api_unit_id) && isset($official->organization) && (string)$api_unit_id === (string)$official->organization->remote_id) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk mengelola pimpinan ini.'], 403);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_term' => 'nullable|date',
            'end_term' => 'nullable|date|after_or_equal:start_term',
            'status' => 'required|in:active,inactive,draft',
            'marital_status' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'home_address' => 'nullable|string',
            'spouse_name' => 'nullable|string|max:255',
            'status_jabatan' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['photo', '_method']);

        if ($request->hasFile('photo')) {
            if ($official->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($official->photo);
            }
            $data['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $data['updated_by'] = $user->id;

        $official->update($data);

        // Sync Relationships
        $official->careerHistories()->delete();
        if ($request->has('career_histories') && is_array($request->career_histories)) {
            foreach ($request->career_histories as $careerData) {
                if (!empty($careerData['title'])) {
                    $official->careerHistories()->create([
                        'title' => $careerData['title'],
                        'organization_name' => $careerData['organization_name'] ?? '',
                        'start_year' => $careerData['start_year'] ?? null,
                        'end_year' => $careerData['end_year'] ?? null,
                        'description' => $careerData['description'] ?? null,
                    ]);
                }
            }
        }

        $official->educations()->delete();
        if ($request->has('educations') && is_array($request->educations)) {
            foreach ($request->educations as $educationData) {
                if (!empty($educationData['degree'])) {
                    $official->educations()->create([
                        'degree' => $educationData['degree'],
                        'institution' => $educationData['institution'] ?? '',
                        'start_year' => $educationData['start_year'] ?? null,
                        'end_year' => $educationData['end_year'] ?? null,
                    ]);
                }
            }
        }

        $official->awards()->delete();
        if ($request->has('awards') && is_array($request->awards)) {
            foreach ($request->awards as $awardData) {
                if (!empty($awardData['title'])) {
                    $official->awards()->create([
                        'title' => $awardData['title'],
                        'issuer' => $awardData['issuer'] ?? '',
                        'year' => $awardData['year'] ?? null,
                        'description' => $awardData['description'] ?? null,
                    ]);
                }
            }
        }
        
        $official->children()->delete();
        if ($request->has('children') && is_array($request->children)) {
            foreach ($request->children as $childData) {
                if (!empty($childData['name'])) {
                    $official->children()->create([
                        'name' => $childData['name'],
                        'birth_place' => $childData['birth_place'] ?? null,
                        'birth_date' => $childData['birth_date'] ?? null,
                    ]);
                }
            }
        }

        $official->trainingHistories()->delete();
        if ($request->has('training_histories') && is_array($request->training_histories)) {
            foreach ($request->training_histories as $trainingData) {
                if (!empty($trainingData['name'])) {
                    $official->trainingHistories()->create([
                        'name' => $trainingData['name'],
                        'year' => $trainingData['year'] ?? null,
                        'organizer' => $trainingData['organizer'] ?? null,
                    ]);
                }
            }
        }

        $official->organizationalHistories()->delete();
        if ($request->has('organizational_histories') && is_array($request->organizational_histories)) {
            foreach ($request->organizational_histories as $orgData) {
                if (!empty($orgData['organization_name'])) {
                    $official->organizationalHistories()->create([
                        'organization_name' => $orgData['organization_name'],
                        'position' => $orgData['position'] ?? '',
                        'start_year' => $orgData['start_year'] ?? null,
                        'end_year' => $orgData['end_year'] ?? null,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Pimpinan berhasil diperbarui.',
            'official' => $official
        ]);
    }
}

