<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubStandarLayanan;
use App\Models\StandarLayanan;
use App\Models\ProfilPpid;
use App\Models\Official;
use App\Models\Lhkpn;
use App\Models\Organization;
use App\Models\OrganizationPosition;
use App\Models\Slider;
use App\Models\Survey;
use App\Models\PbjQuestion;
use App\Models\User;
use App\Models\SecurityBlock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UnifiedAdminCrudController extends Controller
{
    private function checkAdminAccess(Request $request): ?JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }
        $role = strtolower($user->role ?? '');
        $isSuperAdmin = method_exists($user, 'isSuperAdmin') ? $user->isSuperAdmin() : ($role === 'superadmin');
        $isAdmin = in_array($role, ['admin', 'superadmin', 'opd', 'petugas']);

        if (!$isAdmin && !$isSuperAdmin) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }
        return null;
    }

    private function checkSuperadminAccess(Request $request): ?JsonResponse
    {
        $user = $request->user();
        if (!$user) return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        $role = strtolower($user->role ?? '');
        $isSuperAdmin = method_exists($user, 'isSuperAdmin') ? $user->isSuperAdmin() : ($role === 'superadmin');

        if (!$isSuperAdmin) {
            return response()->json(['success' => false, 'message' => 'Akses khusus Superadmin.'], 403);
        }
        return null;
    }

    /**
     * ==========================================
     * 1. STANDAR LAYANAN
     * ==========================================
     */
    public function getStandarLayanan(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $items = SubStandarLayanan::with(['standarLayanan', 'unit'])
            ->when($request->search, function($q, $s) {
                $q->where('nama', 'like', "%{$s}%")->orWhere('deskripsi', 'like', "%{$s}%");
            })
            ->when($request->category_id, function($q, $c) {
                $q->where('standar_layanan_id', $c);
            })
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 15);
        
        $categories = StandarLayanan::all();
        $units = Organization::select('id as unit_id', 'name as unit_nama')->orderBy('name')->get();
        return response()->json([
            'success' => true, 
            'data' => $items, 
            'categories' => $categories,
            'units' => $units
        ]);
    }

    public function showStandarLayanan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $item = SubStandarLayanan::with(['standarLayanan', 'unit'])->findOrFail($id);
        $categories = StandarLayanan::all();
        $units = Organization::select('id as unit_id', 'name as unit_nama')->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => $item,
            'categories' => $categories,
            'units' => $units
        ]);
    }

    public function storeStandarLayanan(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'standar_layanan_id' => 'required',
            'nama' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $filePath = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filePath = $request->file('file')->store('standar_layanan', 'public');
        }

        $item = SubStandarLayanan::create([
            'standar_layanan_id' => $request->standar_layanan_id,
            'unit_id' => $request->unit_id,
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama) . '-' . Str::random(5),
            'deskripsi' => $request->deskripsi,
            'tahun_dokumen' => $request->tahun_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'status' => $request->status ?? 'active',
            'file_path' => $filePath,
        ]);
        return response()->json(['success' => true, 'message' => 'Standar layanan berhasil ditambahkan.', 'data' => $item]);
    }

    public function updateStandarLayanan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $item = SubStandarLayanan::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                Storage::disk('public')->delete($item->file_path);
            }
            $item->file_path = $request->file('file')->store('standar_layanan', 'public');
        }

        if ($request->has('standar_layanan_id')) $item->standar_layanan_id = $request->standar_layanan_id;
        if ($request->has('unit_id')) $item->unit_id = $request->unit_id;
        if ($request->has('nama')) $item->nama = $request->nama;
        if ($request->has('deskripsi')) $item->deskripsi = $request->deskripsi;
        if ($request->has('tahun_dokumen')) $item->tahun_dokumen = $request->tahun_dokumen;
        if ($request->has('jenis_dokumen')) $item->jenis_dokumen = $request->jenis_dokumen;
        if ($request->has('status')) $item->status = $request->status;

        $item->save();
        return response()->json(['success' => true, 'message' => 'Standar layanan berhasil diperbarui.', 'data' => $item]);
    }

    public function deleteStandarLayanan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $item = SubStandarLayanan::findOrFail($id);
        if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
            Storage::disk('public')->delete($item->file_path);
        }
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Standar layanan berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 2. PROFIL PPID
     * ==========================================
     */
    public function getProfilPpid(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $profil = ProfilPpid::first() ?? new ProfilPpid();
        return response()->json(['success' => true, 'data' => $profil]);
    }

    public function updateProfilPpid(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $profil = ProfilPpid::first() ?? new ProfilPpid();

        $profil->fill($request->only([
            'visi', 'misi', 'tugas_fungsi', 'struktur_organisasi', 'sk_ppid', 'bagan_struktur',
            'dasar_hukum', 'maklumat', 'hak_kewajiban'
        ]));

        if ($request->hasFile('file_sk') && $request->file('file_sk')->isValid()) {
            if ($profil->sk_ppid && Storage::disk('public')->exists($profil->sk_ppid)) {
                Storage::disk('public')->delete($profil->sk_ppid);
            }
            $profil->sk_ppid = $request->file('file_sk')->store('profil_ppid', 'public');
        }
        if ($request->hasFile('file_struktur') && $request->file('file_struktur')->isValid()) {
            if ($profil->bagan_struktur && Storage::disk('public')->exists($profil->bagan_struktur)) {
                Storage::disk('public')->delete($profil->bagan_struktur);
            }
            $profil->bagan_struktur = $request->file('file_struktur')->store('profil_ppid', 'public');
        }

        $profil->save();
        return response()->json(['success' => true, 'message' => 'Profil PPID berhasil diperbarui.', 'data' => $profil]);
    }

    /**
     * ==========================================
     * 3. PROFIL PIMPINAN (OFFICIALS) & LHKPN
     * ==========================================
     */
    public function getOfficials(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $officials = Official::with(['organization', 'lhkpnList'])
            ->when($request->search, function($q, $s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('position', 'like', "%{$s}%");
            })
            ->orderBy('order', 'asc')
            ->paginate($request->per_page ?? 20);
        
        $organizations = Organization::select('id', 'name')->orderBy('name')->get();
        return response()->json(['success' => true, 'data' => $officials, 'organizations' => $organizations]);
    }

    public function showOfficial(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $official = Official::with(['organization', 'lhkpnList'])->findOrFail($id);
        $organizations = Organization::select('id', 'name')->orderBy('name')->get();
        return response()->json(['success' => true, 'data' => $official, 'organizations' => $organizations]);
    }

    public function storeOfficial(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:5120'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $photoPath = null;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoPath = $request->file('photo')->store('officials', 'public');
        }

        $official = Official::create([
            'name' => $request->name,
            'position' => $request->position,
            'nip' => $request->nip,
            'slug' => Str::slug($request->name),
            'organization_id' => $request->organization_id,
            'photo' => $photoPath,
            'order' => $request->order ?? 0,
            'status' => $request->status ?? 'active'
        ]);
        return response()->json(['success' => true, 'message' => 'Profil pimpinan berhasil disimpan.', 'data' => $official]);
    }

    public function updateOfficial(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $official = Official::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:255',
            'photo' => 'nullable|image|max:5120'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            if ($official->photo && Storage::disk('public')->exists($official->photo)) {
                Storage::disk('public')->delete($official->photo);
            }
            $official->photo = $request->file('photo')->store('officials', 'public');
        }

        if ($request->has('name')) {
            $official->name = $request->name;
            $official->slug = Str::slug($request->name);
        }
        if ($request->has('position')) $official->position = $request->position;
        if ($request->has('nip')) $official->nip = $request->nip;
        if ($request->has('organization_id')) $official->organization_id = $request->organization_id;
        if ($request->has('order')) $official->order = $request->order;
        if ($request->has('status')) $official->status = $request->status;

        $official->save();
        return response()->json(['success' => true, 'message' => 'Profil pimpinan berhasil diperbarui.', 'data' => $official]);
    }

    public function deleteOfficial(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $off = Official::findOrFail($id);
        if ($off->photo && Storage::disk('public')->exists($off->photo)) {
            Storage::disk('public')->delete($off->photo);
        }
        $off->delete();
        return response()->json(['success' => true, 'message' => 'Profil pimpinan berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 4. ORGANISASI & JABATAN (OPD)
     * ==========================================
     */
    public function getOrganizations(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $orgs = Organization::withCount('positions')
            ->when($request->search, function($q, $s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('alias', 'like', "%{$s}%");
            })
            ->orderBy('name', 'asc')
            ->paginate($request->per_page ?? 25);
        return response()->json(['success' => true, 'data' => $orgs]);
    }

    public function showOrganization(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $org = Organization::findOrFail($id);
        return response()->json(['success' => true, 'data' => $org]);
    }

    public function storeOrganization(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'alias' => 'nullable|string|max:50'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $org = Organization::create([
            'name' => $request->name,
            'alias' => $request->alias,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website
        ]);
        return response()->json(['success' => true, 'message' => 'Unit Organisasi berhasil ditambahkan.', 'data' => $org]);
    }

    public function updateOrganization(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $org = Organization::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'alias' => 'nullable|string|max:50'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        if ($request->has('name')) {
            $org->name = $request->name;
            $org->slug = Str::slug($request->name);
        }
        if ($request->has('alias')) $org->alias = $request->alias;
        if ($request->has('address')) $org->address = $request->address;
        if ($request->has('email')) $org->email = $request->email;
        if ($request->has('phone')) $org->phone = $request->phone;
        if ($request->has('website')) $org->website = $request->website;

        $org->save();
        return response()->json(['success' => true, 'message' => 'Unit Organisasi berhasil diperbarui.', 'data' => $org]);
    }

    public function deleteOrganization(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $org = Organization::findOrFail($id);
        $org->delete();
        return response()->json(['success' => true, 'message' => 'Organisasi berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 5. SLIDERS / BANNER
     * ==========================================
     */
    public function getSliders(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $sliders = Slider::orderBy('order', 'asc')->paginate($request->per_page ?? 15);
        return response()->json(['success' => true, 'data' => $sliders]);
    }

    public function showSlider(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $slider = Slider::findOrFail($id);
        return response()->json(['success' => true, 'data' => $slider]);
    }

    public function storeSlider(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:10240'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $imagePath = $request->file('image')->store('sliders', 'public');
        $slider = Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'image' => $imagePath,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);
        return response()->json(['success' => true, 'message' => 'Banner slider berhasil disimpan.', 'data' => $slider]);
    }

    public function updateSlider(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|max:10240'
            ]);
            if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $slider->image = $request->file('image')->store('sliders', 'public');
        }

        if ($request->has('title')) $slider->title = $request->title;
        if ($request->has('subtitle')) $slider->subtitle = $request->subtitle;
        if ($request->has('link')) $slider->link = $request->link;
        if ($request->has('order')) $slider->order = $request->order;
        if ($request->has('is_active')) $slider->is_active = $request->boolean('is_active');

        $slider->save();
        return response()->json(['success' => true, 'message' => 'Banner slider berhasil diperbarui.', 'data' => $slider]);
    }

    public function deleteSlider(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $slider = Slider::findOrFail($id);
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return response()->json(['success' => true, 'message' => 'Banner slider berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 6. SURVEI KEPUASAN (SKM)
     * ==========================================
     */
    public function getSurveys(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $surveys = Survey::withCount(['questions', 'responses'])
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 15);
        return response()->json(['success' => true, 'data' => $surveys]);
    }

    public function showSurvey(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $survey = Survey::with(['questions'])->withCount(['responses'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $survey]);
    }

    public function storeSurvey(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'year' => 'required|integer'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'year' => $request->year,
            'is_active' => $request->boolean('is_active', true)
        ]);
        return response()->json(['success' => true, 'message' => 'Kuesioner survei berhasil dibuat.', 'data' => $survey]);
    }

    public function updateSurvey(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $survey = Survey::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'year' => 'required|integer'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->year = $request->year;
        if ($request->has('is_active')) {
            $survey->is_active = $request->boolean('is_active');
        }
        $survey->save();

        return response()->json(['success' => true, 'message' => 'Kuesioner survei berhasil diperbarui.', 'data' => $survey]);
    }

    public function deleteSurvey(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $survey = Survey::findOrFail($id);
        $survey->delete();
        return response()->json(['success' => true, 'message' => 'Kuesioner survei berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 7. PENGADAAN BARANG & JASA (PBJ)
     * ==========================================
     */
    public function getPbjQuestions(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $questions = PbjQuestion::when($request->year, function($q, $y) {
                $q->where('year', $y);
            })
            ->orderBy('year', 'desc')
            ->orderBy('order', 'asc')
            ->paginate($request->per_page ?? 25);
        return response()->json(['success' => true, 'data' => $questions]);
    }

    public function showPbjQuestion(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;
        $question = PbjQuestion::findOrFail($id);
        return response()->json(['success' => true, 'data' => $question]);
    }

    public function storePbjQuestion(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'year' => 'required|integer',
            'order' => 'nullable|integer'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $item = PbjQuestion::create([
            'question' => $request->question,
            'year' => $request->year,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);
        return response()->json(['success' => true, 'message' => 'Pertanyaan PBJ berhasil ditambahkan.', 'data' => $item]);
    }

    public function updatePbjQuestion(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $item = PbjQuestion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'year' => 'required|integer',
            'order' => 'nullable|integer'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $item->question = $request->question;
        $item->year = $request->year;
        $item->order = $request->order ?? 0;
        if ($request->has('is_active')) {
            $item->is_active = $request->boolean('is_active');
        }
        $item->save();

        return response()->json(['success' => true, 'message' => 'Pertanyaan PBJ berhasil diperbarui.', 'data' => $item]);
    }

    public function deletePbjQuestion(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $item = PbjQuestion::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Pertanyaan PBJ berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 8. MANAJEMEN USERS & HAK AKSES
     * ==========================================
     */
    public function getUsers(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $users = User::with('unit')
            ->when($request->search, function($q, $s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")->orWhere('nip', 'like', "%{$s}%");
            })
            ->when($request->role, function($q, $r) {
                $q->where('role', $r);
            })
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 20);
        return response()->json(['success' => true, 'data' => $users]);
    }

    public function showUser(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $user = User::with('unit')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function storeUser(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:admin,superadmin,opd,user',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nip' => $request->nip,
            'unit_id' => $request->unit_id,
            'password' => Hash::make($request->password)
        ]);
        return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan.', 'data' => $user]);
    }

    public function updateUser(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,superadmin,opd,user',
            'password' => 'nullable|string|min:6'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->nip = $request->nip;
        $user->unit_id = $request->unit_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return response()->json(['success' => true, 'message' => 'Data pengguna berhasil diperbarui.', 'data' => $user]);
    }

    public function deleteUser(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $user = User::findOrFail($id);
        if ($user->id === $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri.'], 400);
        }
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
    }

    /**
     * ==========================================
     * 9. SECURITY BLOCKS & TRACKER
     * ==========================================
     */
    public function getSecurityBlocks(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $blocks = SecurityBlock::orderBy('id', 'desc')->paginate($request->per_page ?? 25);
        return response()->json(['success' => true, 'data' => $blocks]);
    }

    public function showSecurityBlock(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $block = SecurityBlock::findOrFail($id);
        return response()->json(['success' => true, 'data' => $block]);
    }

    public function storeSecurityBlock(Request $request): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $validator = Validator::make($request->all(), [
            'ip_address' => 'required|string|max:45',
            'reason' => 'required|string|max:255'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $block = SecurityBlock::create([
            'ip_address' => $request->ip_address,
            'reason' => $request->reason,
            'blocked_at' => now(),
            'expires_at' => $request->expires_at
        ]);
        return response()->json(['success' => true, 'message' => 'Blokir IP berhasil diterapkan.', 'data' => $block]);
    }

    public function updateSecurityBlock(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $block = SecurityBlock::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ip_address' => 'required|string|max:45',
            'reason' => 'required|string|max:255'
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $block->ip_address = $request->ip_address;
        $block->reason = $request->reason;
        if ($request->has('expires_at')) {
            $block->expires_at = $request->expires_at;
        }
        $block->save();

        return response()->json(['success' => true, 'message' => 'Data blokir IP diperbarui.', 'data' => $block]);
    }

    public function deleteSecurityBlock(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkSuperadminAccess($request)) return $denied;
        $block = SecurityBlock::findOrFail($id);
        $block->delete();
        return response()->json(['success' => true, 'message' => 'Blokir IP telah dicabut.']);
    }
}
