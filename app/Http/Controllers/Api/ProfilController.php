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
                         ->where('status', '!=', 'draft') // Default to public view logic
                         ->with(['position', 'organization']);
                         
        $kepalaOpdsRaw = $query->orderBy('full_name')->get();
        
        $kepalaOpds = $kepalaOpdsRaw->groupBy(function($official) {
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
        $organizations = Organization::with('strukturOrganisasi.informasi')->get();
        $unitData = collect(GeneralHelper::getUnitData());

        $organizations->each(function ($organization) use ($unitData) {
            $matchingUnit = $unitData->get($organization->remote_id);
            if ($matchingUnit) {
                if (empty($matchingUnit['unit_alamat']) || $matchingUnit['unit_alamat'] === '0') {
                    $organization->api_address = 'Alamat belum ditambahkan';
                } else {
                    $organization->api_address = $matchingUnit['unit_alamat'];
                }
            } else {
                $organization->api_address = 'Alamat belum ditambahkan';
            }
        });

        return response()->json([
            'organizations' => $organizations
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

    public function unitLokalList()
    {
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        
        // Find the 'Kepala OPD' position or similar that is used for Village Heads
        $position = Position::where('slug', 'kepala-opd')->first();
        
        $query = Official::with(['organization', 'position']);
        $query->where('status', 'active');

        // Fetch all officials belonging to Village/Kelurahan organizations
        $allOfficials = $query->get()->filter(function($official) {
            $orgName = $official->organization->name ?? '';
            return stripos($orgName, 'Desa ') !== false || stripos($orgName, 'Kelurahan ') !== false;
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
}
