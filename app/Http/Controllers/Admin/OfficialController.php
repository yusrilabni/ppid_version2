<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\Position;
use App\Models\Organization;
use App\Models\OrganizationPosition;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $officialsQuery = Official::select('officials.*')
            ->join('positions', 'officials.position_id', '=', 'positions.id')
            ->leftJoin('organizations', 'officials.organization_id', '=', 'organizations.id')
            ->orderByRaw("
                CASE
                    WHEN positions.slug = 'bupati-sinjai' THEN 1
                    WHEN positions.slug = 'wakil-bupati-sinjai' THEN 2
                    WHEN positions.slug = 'sekretaris-daerah-sinjai' THEN 3
                    WHEN positions.slug = 'asisten-i-pemerintahan-dan-kesra' THEN 4
                    WHEN positions.slug = 'asisten-ii-perekonomian-dan-pembangunan' THEN 5
                    WHEN positions.slug = 'asisten-iii-administrasi-umum' THEN 6
                    WHEN positions.slug = 'staf-ahli-bidang-politik-hukum-dan-pemerintahan' THEN 7
                    WHEN positions.slug = 'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan' THEN 8
                    WHEN positions.slug = 'staf-ahli-bidang-sosial-dan-sumber-daya-manusia' THEN 9
                    WHEN positions.slug = 'kepala-opd' THEN 10
                    ELSE 99
                END
            ")
            ->orderBy('organizations.name', 'asc')
            ->with(['position', 'organization']);

        if ($search) {
            $officialsQuery->where(function ($q) use ($search) {
                $q->where('officials.full_name', 'like', "%{$search}%")
                  ->orWhere('positions.name', 'like', "%{$search}%")
                  ->orWhere('organizations.name', 'like', "%{$search}%");
            });
        }

        $officials = $officialsQuery->paginate(20)->appends(['search' => $search]);

        return view('admin.officials.index', compact('officials', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Fetch all positions and separate Kepala OPD
        $allPositions = Position::orderByRaw("
            CASE
                WHEN slug = 'bupati-sinjai' THEN 1
                WHEN slug = 'wakil-bupati-sinjai' THEN 2
                WHEN slug = 'sekretaris-daerah-sinjai' THEN 3
                ELSE 4
            END
        ")->get();

        $kepalaOpdPosition = $allPositions->firstWhere('slug', 'kepala-opd');
        $otherPositions = $allPositions->where('slug', '!=', 'kepala-opd');

        // 2. Fetch all root OrganizationPositions (Kepala OPDs for each organization)
        $kepalaOpdOrganizationPositions = OrganizationPosition::whereNull('parent_id')
            ->with('organization')
            ->get();

        // 3. Create a unified list for the dropdown
        $unifiedPositions = [];

        // Add other positions first
        foreach ($otherPositions as $position) {
            $unifiedPositions[] = [
                'is_optgroup' => false,
                'id' => $position->id,
                'name' => $position->name,
                'organization_id' => null,
            ];
        }

        // Add an optgroup for Kepala OPD
        if ($kepalaOpdPosition && $kepalaOpdOrganizationPositions->isNotEmpty()) {
            $unifiedPositions[] = [
                'is_optgroup' => true,
                'label' => 'Kepala OPD',
            ];

            foreach ($kepalaOpdOrganizationPositions as $orgPos) {
                if ($orgPos->organization) {
                    $unifiedPositions[] = [
                        'is_optgroup' => false,
                        'id' => $kepalaOpdPosition->id, // Use the generic 'Kepala OPD' position ID
                        'name' => 'Kepala ' . $orgPos->organization->name,
                        'organization_id' => $orgPos->organization->id, // Pass the specific organization ID
                    ];
                }
            }
        }
        
        $organizations = Organization::all();

        return view('admin.officials.create', [
            'positions' => $unifiedPositions,
            'organizations' => $organizations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'position_id' => 'required|exists:positions,id',
            'organization_id' => 'nullable|exists:organizations,id',
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

        // Check position validation rules
        $position = Position::find($request->position_id);

        // For Kepala OPD, only one per OPD can be active
        if ($position && strtolower($position->slug) === 'kepala-opd' && $request->status === 'active') {
            if (!$request->organization_id) {
                return redirect()->back()
                                ->withErrors(['organization_id' => 'Organisasi wajib dipilih untuk posisi Kepala OPD.'])
                                ->withInput();
            }

            $existingActive = Official::where('position_id', $request->position_id)
                                     ->where('organization_id', $request->organization_id)
                                     ->where('status', 'active')
                                     ->first();

            if ($existingActive) {
                return redirect()->back()
                                ->withErrors(['status' => 'OPD ini hanya boleh memiliki satu Kepala OPD aktif.'])
                                ->withInput();
            }
        }
        
        DB::transaction(function () use ($request) {
            $position = Position::find($request->position_id);

            // If the new official is active and the position is 'is_single',
            // find any existing active official with the same position and set them to 'draft'.
            if ($request->status === 'active' && $position && $position->is_single) {
                Official::where('position_id', $request->position_id)
                        ->where('status', 'active')
                        ->update(['status' => 'draft']);
            }
            
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('officials', 'public');
            }

            // Generate unique slug from full name
            $baseSlug = strtolower(str_replace(' ', '-', $request->full_name));
            $slug = $baseSlug;
            $counter = 1;

            // Check if slug already exists and make it unique
            while (Official::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $official = Official::create([
                'full_name' => $request->full_name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'position_id' => $request->position_id,
                'organization_id' => $request->organization_id,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'religion' => $request->religion,
                'nip' => $request->nip,
                'biography' => $request->biography,
                'photo' => $photoPath,
                'start_term' => $request->start_term,
                'end_term' => $request->end_term,
                'status' => $request->status,
                'slug' => $slug,
                'marital_status' => $request->marital_status,
                'occupation' => $request->occupation,
                'email' => $request->email,
                'home_address' => $request->home_address,
                'spouse_name' => $request->spouse_name,
                'status_jabatan' => $request->status_jabatan,
            ]);

            // Save career histories
            if ($request->has('career_histories')) {
                foreach ($request->career_histories as $careerData) {
                    if (!empty($careerData['title'] ?? '') || !empty($careerData['organization_name'] ?? '')) {
                        $official->careerHistories()->create([
                            'title' => $careerData['title'] ?? '',
                            'organization_name' => $careerData['organization_name'] ?? '',
                            'start_year' => !empty($careerData['start_date'] ?? null) ? (int)date('Y', strtotime($careerData['start_date'])) : (!empty($careerData['start_year'] ?? null) ? (int)$careerData['start_year'] : null),
                            'end_year' => !empty($careerData['end_date'] ?? null) ? (int)date('Y', strtotime($careerData['end_date'])) : (!empty($careerData['end_year'] ?? null) ? (int)$careerData['end_year'] : null),
                            'description' => $careerData['description'] ?? ''
                        ]);
                    }
                }
            }

            // Save educations
            if ($request->has('educations')) {
                foreach ($request->educations as $educationData) {
                    if (!empty($educationData['degree'] ?? '') || !empty($educationData['institution'] ?? '')) {
                        $official->educations()->create([
                            'degree' => $educationData['degree'] ?? '',
                            'institution' => $educationData['institution'] ?? '',
                            'start_year' => !empty($educationData['start_year'] ?? null) ? (int)$educationData['start_year'] : null,
                            'end_year' => !empty($educationData['end_year'] ?? null) ? (int)$educationData['end_year'] : null
                        ]);
                    }
                }
            }

            // Save awards
            if ($request->has('awards')) {
                foreach ($request->awards as $awardData) {
                    if (!empty($awardData['title'] ?? '') || !empty($awardData['issuer'] ?? '')) {
                        $official->awards()->create([
                            'title' => $awardData['title'] ?? '',
                            'issuer' => $awardData['issuer'] ?? '',
                            'year' => !empty($awardData['date'] ?? null) ? (int)date('Y', strtotime($awardData['date'])) : (!empty($awardData['year'] ?? null) ? (int)$awardData['year'] : null),
                            'description' => $awardData['description'] ?? ''
                        ]);
                    }
                }
            }

            // Save children
            if ($request->has('children')) {
                foreach ($request->children as $childData) {
                    if (!empty($childData['name'])) {
                        $official->children()->create($childData);
                    }
                }
            }

            // Save training histories
            if ($request->has('training_histories')) {
                foreach ($request->training_histories as $trainingData) {
                    if (!empty($trainingData['name'])) {
                        $official->trainingHistories()->create($trainingData);
                    }
                }
            }

            // Save organizational histories
            if ($request->has('organizational_histories')) {
                foreach ($request->organizational_histories as $orgData) {
                    if (!empty($orgData['organization_name'])) {
                        // Ensure position field has a value, even if it's empty
                        $orgData['position'] = $orgData['position'] ?? '';
                        $official->organizationalHistories()->create($orgData);
                    }
                }
            }
            
            // Create a corresponding Informasi record
            $user = Auth::user();
            $positionName = $official->position ? $official->position->name : 'Pimpinan';

            Informasi::create([
                'title' => 'Profil Pimpinan ' . $positionName,
                'deskripsi' => 'Dokumen ini berisi data dari profil pimpinan.',
                'content' => json_encode($official->load([
                    'careerHistories', 
                    'educations', 
                    'awards', 
                    'children', 
                    'trainingHistories', 
                    'organizationalHistories'
                ])),
                'jenis_dokumen' => 'Informasi Organisasi & Kepegawaian',
                'category' => 'Informasi Berkala',
                'status' => $official->status === 'active' ? 'BERLAKU' : 'ARSIP',
                'tahun' => $official->start_term ? date('Y', strtotime($official->start_term)) : date('Y'),
                'tanggal_upload' => $official->start_term ?? now(),
                'user_id' => $user->id,
                'unit_id' => $user->unit_id,
                'official_id' => $official->id,
            ]);
        });

        return redirect()->route('admin.officials.index')
                         ->with('success', 'Profil pimpinan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Official $official)
    {
        $positions = Position::orderByRaw("
            CASE
                WHEN slug = 'bupati-sinjai' THEN 1
                WHEN slug = 'wakil-bupati-sinjai' THEN 2
                WHEN slug = 'sekretaris-daerah-sinjai' THEN 3
                WHEN slug = 'asisten-i-pemerintahan-dan-kesra' THEN 4
                WHEN slug = 'asisten-ii-perekonomian-dan-pembangunan' THEN 5
                WHEN slug = 'asisten-iii-administrasi-umum' THEN 6
                WHEN slug = 'staf-ahli-bidang-politik-hukum-dan-pemerintahan' THEN 7
                WHEN slug = 'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan' THEN 8
                WHEN slug = 'staf-ahli-bidang-sosial-dan-sumber-daya-manusia' THEN 9
                WHEN slug = 'kepala-opd' THEN 10
                ELSE 99
            END
        ")->get();
        $organizations = Organization::all();
        return view('admin.officials.edit', compact('official', 'positions', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Official $official)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'position_id' => 'required|exists:positions,id',
            'organization_id' => 'nullable|exists:organizations,id',
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

        // Check position validation rules
        $position = Position::find($request->position_id);

        // For Kepala OPD, only one per OPD can be active
        if ($position && strtolower($position->slug) === 'kepala-opd' && $request->status === 'active') {
            if (!$request->organization_id) {
                return redirect()->back()
                                ->withErrors(['organization_id' => 'Organisasi wajib dipilih untuk posisi Kepala OPD.'])
                                ->withInput();
            }

            $existingActive = Official::where('position_id', $request->position_id)
                                     ->where('organization_id', $request->organization_id)
                                     ->where('status', 'active')
                                     ->where('id', '!=', $official->id) // Exclude current official
                                     ->first();

            if ($existingActive) {
                return redirect()->back()
                                ->withErrors(['status' => 'OPD ini hanya boleh memiliki satu Kepala OPD aktif.'])
                                ->withInput();
            }
        }

        DB::transaction(function () use ($request, $official) {
            $position = Position::find($request->position_id);

            // If the new official is active and the position is 'is_single',
            // find any existing active official with the same position and set them to 'draft'.
            if ($request->status === 'active' && $position && $position->is_single) {
                Official::where('position_id', $request->position_id)
                        ->where('status', 'active')
                        ->where('id', '!=', $official->id) // Exclude current official
                        ->update(['status' => 'draft']);
            }
            
            $photoPath = $official->photo;
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($official->photo) {
                    $oldPath = storage_path('app/public/' . $official->photo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $photoPath = $request->file('photo')->store('officials', 'public');
            }

            // Generate unique slug from full name (avoiding current official's slug)
            $baseSlug = strtolower(str_replace(' ', '-', $request->full_name));
            $slug = $baseSlug;
            $counter = 1;

            // Check if slug already exists and make it unique, excluding current official
            while (Official::where('slug', $slug)->where('id', '!=', $official->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $official->update([
                'full_name' => $request->full_name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'position_id' => $request->position_id,
                'organization_id' => $request->organization_id,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'religion' => $request->religion,
                'nip' => $request->nip,
                'biography' => $request->biography,
                'photo' => $photoPath,
                'start_term' => $request->start_term,
                'end_term' => $request->end_term,
                'status' => $request->status,
                'slug' => $slug,
                'marital_status' => $request->marital_status,
                'occupation' => $request->occupation,
                'email' => $request->email,
                'home_address' => $request->home_address,
                'spouse_name' => $request->spouse_name,
                'status_jabatan' => $request->status_jabatan,
            ]);

            // Update career histories - delete existing and add new ones
            $official->careerHistories()->delete();
            if ($request->has('career_histories')) {
                foreach ($request->career_histories as $careerData) {
                    if (!empty($careerData['title'] ?? '') || !empty($careerData['organization_name'] ?? '')) {
                        $official->careerHistories()->create([
                            'title' => $careerData['title'] ?? '',
                            'organization_name' => $careerData['organization_name'] ?? '',
                            'start_year' => !empty($careerData['start_date'] ?? null) ? (int)date('Y', strtotime($careerData['start_date'])) : (!empty($careerData['start_year'] ?? null) ? (int)$careerData['start_year'] : null),
                            'end_year' => !empty($careerData['end_date'] ?? null) ? (int)date('Y', strtotime($careerData['end_date'])) : (!empty($careerData['end_year'] ?? null) ? (int)$careerData['end_year'] : null),
                            'description' => $careerData['description'] ?? ''
                        ]);
                    }
                }
            }

            // Update educations - delete existing and add new ones
            $official->educations()->delete();
            if ($request->has('educations')) {
                foreach ($request->educations as $educationData) {
                    if (!empty($educationData['degree'] ?? '') || !empty($educationData['institution'] ?? '')) {
                        $official->educations()->create([
                            'degree' => $educationData['degree'] ?? '',
                            'institution' => $educationData['institution'] ?? '',
                            'start_year' => !empty($educationData['start_year'] ?? null) ? (int)$educationData['start_year'] : null,
                            'end_year' => !empty($educationData['end_year'] ?? null) ? (int)$educationData['end_year'] : null
                        ]);
                    }
                }
            }

            // Update awards - delete existing and add new ones
            $official->awards()->delete();
            if ($request->has('awards')) {
                foreach ($request->awards as $awardData) {
                    if (!empty($awardData['title'] ?? '') || !empty($awardData['issuer'] ?? '')) {
                        $official->awards()->create([
                            'title' => $awardData['title'] ?? '',
                            'issuer' => $awardData['issuer'] ?? '',
                            'year' => !empty($awardData['date'] ?? null) ? (int)date('Y', strtotime($awardData['date'])) : (!empty($awardData['year'] ?? null) ? (int)$awardData['year'] : null),
                            'description' => $awardData['description'] ?? ''
                        ]);
                    }
                }
            }

            // Update children
            $official->children()->delete();
            if ($request->has('children')) {
                foreach ($request->children as $childData) {
                    if (!empty($childData['name'])) {
                        $official->children()->create($childData);
                    }
                }
            }

            // Update training histories
            $official->trainingHistories()->delete();
            if ($request->has('training_histories')) {
                foreach ($request->training_histories as $trainingData) {
                    if (!empty($trainingData['name'])) {
                        $official->trainingHistories()->create($trainingData);
                    }
                }
            }

            // Update organizational histories
            $official->organizationalHistories()->delete();
            if ($request->has('organizational_histories')) {
                foreach ($request->organizational_histories as $orgData) {
                    if (!empty($orgData['organization_name'])) {
                        // Ensure position field has a value, even if it's empty
                        $orgData['position'] = $orgData['position'] ?? '';
                        $official->organizationalHistories()->create($orgData);
                    }
                }
            }
            
            // Update corresponding Informasi record
            // Load official's position if not already loaded
            $official->loadMissing('position');
            $user = Auth::user(); // Assuming the user is still logged in

            $informasi = Informasi::firstOrNew(['official_id' => $official->id]);
            
            $positionName = $official->position ? $official->position->name : 'Pimpinan';

            $informasi->title = 'Profil Pimpinan ' . $positionName;
            $informasi->deskripsi = 'Dokumen ini berisi data dari profil pimpinan.';
            $informasi->content = json_encode($official->load([
                'careerHistories', 
                'educations', 
                'awards', 
                'children', 
                'trainingHistories', 
                'organizationalHistories'
            ]));
            $informasi->jenis_dokumen = 'Informasi Organisasi & Kepegawaian';
            $informasi->category = 'Informasi Berkala';
            $informasi->status = $official->status === 'active' ? 'BERLAKU' : 'ARSIP';
            $informasi->tahun = $official->start_term ? date('Y', strtotime($official->start_term)) : date('Y');
            $informasi->tanggal_upload = $official->start_term ?? now();
            $informasi->user_id = $user->id;
            $informasi->unit_id = $user->unit_id;
            // official_id is already set by firstOrNew or remains the same
            $informasi->save();
        });

        return redirect()->route('admin.officials.index')
                         ->with('success', 'Profil pimpinan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Official $official)
    {
        // Delete photo if exists
        if ($official->photo) {
            $path = storage_path('app/public/' . $official->photo);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $official->delete();

        return redirect()->route('admin.officials.index')
                         ->with('success', 'Profil pimpinan berhasil dihapus.');
    }

    public function updateStatus(Official $official, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,draft'
        ]);

        // Check position validation rules
        $position = $official->position;

        // For single positions (Bupati, Wakil Bupati, Sekda), only one can be active
        if ($position && $position->is_single && $request->status === 'active') {
            $existingActive = Official::where('position_id', $official->position_id)
                                     ->where('status', 'active')
                                     ->where('id', '!=', $official->id) // Exclude current official
                                     ->first();

            if ($existingActive) {
                return response()->json(['success' => false, 'message' => 'Posisi ini hanya boleh diisi oleh satu orang aktif.'], 422);
            }
        }

        // For Kepala OPD, only one per OPD can be active
        if ($position && strtolower($position->slug) === 'kepala-opd' && $request->status === 'active') {
            if (!$official->organization_id) {
                return response()->json(['success' => false, 'message' => 'Organisasi wajib dipilih untuk posisi Kepala OPD.'], 422);
            }

            $existingActive = Official::where('position_id', $official->position_id)
                                     ->where('organization_id', $official->organization_id)
                                     ->where('status', 'active')
                                     ->where('id', '!=', $official->id) // Exclude current official
                                     ->first();

            if ($existingActive) {
                return response()->json(['success' => false, 'message' => 'OPD ini hanya boleh memiliki satu Kepala OPD aktif.'], 422);
            }
        }

        $official->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}
