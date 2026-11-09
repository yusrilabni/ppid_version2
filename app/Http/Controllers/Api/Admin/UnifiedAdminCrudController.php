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
        $items = SubStandarLayanan::with('standarLayanan')
            ->when($request->search, function($q, $s) {
                $q->where('nama', 'like', "%{$s}%")->orWhere('deskripsi', 'like', "%{$s}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 15);
        
        $categories = StandarLayanan::all();
        return response()->json(['success' => true, 'data' => $items, 'categories' => $categories]);
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
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama) . '-' . Str::random(5),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
        ]);
        return response()->json(['success' => true, 'message' => 'Standar layanan berhasil ditambahkan.', 'data' => $item]);
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
            'visi', 'misi', 'tugas_fungsi', 'struktur_organisasi', 'sk_ppid', 'bagan_struktur'
        ]));

        if ($request->hasFile('file_sk') && $request->file('file_sk')->isValid()) {
            $profil->sk_ppid = $request->file('file_sk')->store('profil_ppid', 'public');
        }
        if ($request->hasFile('file_struktur') && $request->file('file_struktur')->isValid()) {
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
        return response()->json(['success' => true, 'data' => $officials]);
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
}
