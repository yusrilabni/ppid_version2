<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Informasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;

class InformasiController extends Controller
{
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $informasis = Informasi::all();
        } else {
            // Admin biasa hanya bisa melihat informasi dari unit kerjanya
            $informasis = Informasi::where('unit_id', $user->unit_id)->get();
        }
        return view('informasi-crud.index', compact('informasis'));
    }

    public function create($category = null)
    {
        $categoryMapping = [
            'berkala' => 'Informasi Berkala',
            'setiap-saat' => 'Informasi Setiap Saat',
            'serta-merta' => 'Informasi Serta Merta',
            'dikecualikan' => 'Informasi Dikecualikan',
        ];
        $selectedCategory = $categoryMapping[$category] ?? null;

        $menuConfig = config('menu');
        $informasiCategoryMenu = collect($menuConfig)->firstWhere('title', 'Kategori Informasi');
        $categoryIcon = 'fas fa-info-circle'; // Default icon
        if ($informasiCategoryMenu && isset($informasiCategoryMenu['children'])) {
            $matchingItem = collect($informasiCategoryMenu['children'])->firstWhere('url', '/informasi/' . $category);
            if ($matchingItem && isset($matchingItem['icon'])) {
                $categoryIcon = 'fas fa-' . $matchingItem['icon'];
            }
        }

        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();
        $viewData = [
            'selectedCategory' => $selectedCategory,
            'categorySlug' => $category,
            'categoryIcon' => $categoryIcon,
            'isSuperAdmin' => $isSuperAdmin,
        ];

        $allUnitsCached = GeneralHelper::getCachedUnits();
        $allUnits = GeneralHelper::getEncodedUnitData();
        $unitMap = $allUnits->keyBy('unit_id');

        if ($isSuperAdmin) {
            $viewData['units'] = $allUnits;
            $viewData['villagesGrouped'] = $allUnitsCached['villages_grouped'] ?? [];
        } else {
            // Prioritaskan unit_id dari tabel users (untuk Admin Desa/Manual)
            $userUnitId = $user->unit_id;
            $userUnitName = 'Unit Tidak Diketahui';

            // Jika tidak ada di tabel users, coba tarik dari API (fallback)
            if (!$userUnitId && $user->nip) {
                $apiUserData = \App\Models\User::getDataFromApi($user->nip);
                if ($apiUserData && isset($apiUserData['unit_id'])) {
                    $userUnitId = $apiUserData['unit_id'];
                }
            }

            // Seleksi encoding: hanya encode jika 6 digit (Dinas/Kecamatan)
            if ($userUnitId) {
                $rawId = (string)$userUnitId;
                $processedId = (strlen($rawId) === 6) ? 'B64_' . base64_encode($rawId) : $rawId;
                
                $unitInfo = $unitMap->get($processedId);
                if ($unitInfo) {
                    $userUnitId = $processedId;
                    $userUnitName = $unitInfo['unit_nama'];
                } else {
                    $rawUnits = GeneralHelper::getUnitData();
                    $rawUnitInfo = $rawUnits->get($rawId);
                    if ($rawUnitInfo) {
                        $userUnitId = $processedId;
                        $userUnitName = $rawUnitInfo['unit_nama'];
                    }
                }
            }

            $viewData['userUnitId'] = $userUnitId;
            $viewData['userUnitName'] = $userUnitName;
        }

        $viewData['show_pedoman_modal'] = session('show_pedoman_modal', false);
        if (session('show_pedoman_modal')) {
            session()->forget('show_pedoman_modal');
        }

        return view('informasi-crud.create', $viewData);
    }

    public function edit(Informasi $informasi)
    {
        $categoryName = $informasi->category;
        $categorySlug = $informasi->category_slug;

        $menuConfig = config('menu');
        $informasiCategoryMenu = collect($menuConfig)->firstWhere('title', 'Kategori Informasi');
        $categoryIcon = 'fas fa-info-circle'; // Default icon
        if ($informasiCategoryMenu && isset($informasiCategoryMenu['children'])) {
            $matchingItem = collect($informasiCategoryMenu['children'])->firstWhere('url', '/informasi/' . $categorySlug);
            if ($matchingItem && isset($matchingItem['icon'])) {
                $categoryIcon = 'fas fa-' . $matchingItem['icon'];
            }
        }

        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();
        $viewData = [
            'informasi' => $informasi,
            'categoryName' => $categoryName,
            'categorySlug' => $categorySlug,
            'categoryIcon' => $categoryIcon,
            'isSuperAdmin' => $isSuperAdmin,
        ];

        $allUnitsCached = GeneralHelper::getCachedUnits();
        $allUnits = GeneralHelper::getEncodedUnitData();
        $unitMap = $allUnits->keyBy('unit_id');

        if ($isSuperAdmin) {
            $viewData['units'] = $allUnits;
            $viewData['villagesGrouped'] = $allUnitsCached['villages_grouped'] ?? [];
            if ($informasi->unit_id) {
                $viewData['currentUnitId'] = $informasi->unit_id;
            }
        } else {
            // Gunakan ID asli (RAW) tanpa encode karena terbukti ID panjang (Desa) berhasil tanpa encode.
            // Kita akan mengganti nama parameter di form agar lolos WAF.
            $userUnitId = $informasi->unit_id ?: $user->unit_id;
            $userUnitName = 'Unit Tidak Diketahui';

            if (!$userUnitId && $user->nip) {
                $apiUserData = \App\Models\User::getDataFromApi($user->nip);
                if ($apiUserData && isset($apiUserData['unit_id'])) {
                    $userUnitId = $apiUserData['unit_id'];
                }
            }

            if ($userUnitId) {
                $unitInfo = $unitMap->get($userUnitId);
                if ($unitInfo) {
                    $userUnitName = $unitInfo['unit_nama'];
                } else {
                    $rawUnits = GeneralHelper::getUnitData();
                    $rawUnitInfo = $rawUnits->get($userUnitId);
                    if ($rawUnitInfo) {
                        $userUnitName = $rawUnitInfo['unit_nama'];
                    }
                }
            }

            $viewData['userUnitId'] = $userUnitId;
            $viewData['userUnitName'] = $userUnitName;
        }

        return view('informasi-crud.edit', $viewData);
    }

    public function checkSimilarity(Request $request)
    {
        try {
            $title = $request->input('title');
            if (!$title || strlen($title) < 5) {
                return response()->json([]);
            }

            $user = auth()->user();
            $targetUnit = $request->input('target_unit'); 
            
            \Log::info("Checking similarity for User: {$user->id}, Unit: {$targetUnit}, Title: {$title}");

            $query = Informasi::whereIn('status', ['BERLAKU', 'aktif']);

            if ($user->isSuperAdmin()) {
                if (!empty($targetUnit)) {
                    $query->where('unit_id', (string)$targetUnit);
                } else {
                    return response()->json([]);
                }
            } else {
                $userUnitId = (string)($user->unit_id ?: '');
                if (empty($userUnitId) && !empty($user->nip)) {
                    $apiData = User::getDataFromApi($user->nip);
                    if ($apiData && !empty($apiData['unit_id'])) {
                        $userUnitId = (string)$apiData['unit_id'];
                    }
                }
                $query->where('unit_id', $userUnitId);
            }

            // Optimasi awal
            $words = explode(' ', trim($title));
            if (count($words) > 0) {
                $firstWord = $words[0];
                if (strlen($firstWord) >= 3) {
                    $query->where('title', 'LIKE', '%' . $firstWord . '%');
                }
            }

            $activeInformasis = $query->limit(50)->get();
            $similar_documents = [];

            foreach ($activeInformasis as $informasi) {
                $similarity = 0;
                similar_text(strtolower($title), strtolower($informasi->title), $similarity);

                if ($similarity > 80) {
                    $similar_documents[] = [
                        'id' => $informasi->id,
                        'title' => $informasi->title,
                    ];
                }
            }

            return response()->json($similar_documents);
        } catch (\Exception $e) {
            \Log::error("Similarity Check Error: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Store Informari Attempt', ['user' => auth()->user()->nip]);
        
        $user = Auth::user();
        
        // KRUSIAL: Pastikan unit_id tersedia sebelum proses berlanjut
        if (empty($user->unit_id) && !empty($user->nip)) {
            $apiData = User::getDataFromApi($user->nip);
            if ($apiData && !empty($apiData['unit_id'])) {
                $user->unit_id = $apiData['unit_id'];
                $user->save(); 
                Log::info('User unit_id synced from API', ['unit_id' => $user->unit_id]);
            }
        }

        $isSuperAdmin = $user->isSuperAdmin();

        $validationRules = [
            'title' => 'required|string|min:5|max:255',
            'doc_desc' => 'nullable|string|max:65535',
            'doc_content' => 'nullable|string',
            'category' => ['required', 'string', 'in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan'],
            'jenis_dokumen' => 'nullable|string',
            'tahun' => 'required|date',
            'status' => 'required|string|in:BERLAKU,ARSIP',
            'file_type' => 'required|in:upload,url',
            'replacement_id' => 'nullable|integer|exists:informasis,id'
        ];

        if ($isSuperAdmin) {
            $validationRules['target_unit'] = 'required|string';
        }

        if ($request->input('file_type') === 'url') {
            $validationRules['url'] = 'required|url';
        } else {
            $validationRules['file'] = 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048';
        }
        
        $validatedData = $request->validate($validationRules);
        
        try {
            DB::transaction(function () use ($request, $validatedData, $user, $isSuperAdmin) {
                // Map back to database columns
                $dataToSave = [
                    'title' => $validatedData['title'],
                    'deskripsi' => $validatedData['doc_desc'],
                    'content' => $validatedData['doc_content'],
                    'category' => $validatedData['category'],
                    'jenis_dokumen' => $validatedData['jenis_dokumen'],
                    'tahun' => $validatedData['tahun'],
                    'status' => $validatedData['status'],
                    'file_type' => $validatedData['file_type'],
                ];

                // ... logic archive ...
                if ($request->filled('replacement_id')) {
                    $informasiToArchive = Informasi::find($request->replacement_id);
                    if ($informasiToArchive) {
                        if ($user->cannot('update', $informasiToArchive)) {
                            throw new AuthorizationException('Anda tidak diizinkan mengubah dokumen unit lain.');
                        }
                        $informasiToArchive->status = 'ARSIP';
                        $informasiToArchive->save();
                    }
                }

                $tanggal_dokumen = Carbon::parse($validatedData['tahun']);
                
                if ($request->input('file_type') === 'upload' && $request->hasFile('file')) {
                    $dataToSave['file'] = $this->storeFileWithCompression($request->file('file'));
                    $dataToSave['url'] = null;
                } else {
                    $dataToSave['url'] = $validatedData['url'] ?? null;
                    $dataToSave['file'] = null;
                }

                $dataToSave['tanggal_upload'] = $tanggal_dokumen->toDateString();
                $dataToSave['tahun'] = $tanggal_dokumen->format('Y');
                $dataToSave['user_id'] = $user->id;
                $dataToSave['unit_id'] = $isSuperAdmin ? $request->target_unit : $user->unit_id;

                if (!$dataToSave['unit_id']) {
                    throw new \Exception("Gagal menentukan Unit ID. Silakan hubungi Superadmin.");
                }

                Informasi::create($dataToSave);
            });
        } catch (\Exception $e) {
            Log::error('Store Informasi Failed', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        Cache::forget('dip_years');
        return redirect()->route('frontend.informasi.category', ['category' => Str::slug(str_replace('Informasi ', '', $validatedData['category']))])
            ->with('success', 'Data berhasil disimpan.');
    }
    
    public function update(Request $request, Informasi $informasi)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();

        $validationRules = [
            'title' => 'required|string|min:5|max:255',
            'doc_desc' => 'nullable|string|max:65535',
            'doc_content' => 'nullable|string',
            'category' => ['required', 'string', 'in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan'],
            'jenis_dokumen' => 'nullable|string',
            'tahun' => 'required|date',
            'status' => 'required|string|in:BERLAKU,ARSIP',
            'file_type' => 'required|in:upload,url',
            'replacement_id' => 'nullable|integer|exists:informasis,id'
        ];

        if ($isSuperAdmin) {
            $validationRules['target_unit'] = 'required|string';
        }

        if ($request->input('file_type') === 'url') {
            $validationRules['url'] = 'required|url';
        } else {
            $validationRules['file'] = 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048';
        }
        
        $validatedData = $request->validate($validationRules);

        try {
            DB::transaction(function () use ($request, $informasi, $validatedData, $isSuperAdmin, $user) {
                // Map back to database columns
                $dataToUpdate = [
                    'title' => $validatedData['title'],
                    'deskripsi' => $validatedData['doc_desc'],
                    'content' => $validatedData['doc_content'],
                    'category' => $validatedData['category'],
                    'jenis_dokumen' => $validatedData['jenis_dokumen'],
                    'tahun' => $validatedData['tahun'],
                    'status' => $validatedData['status'],
                    'file_type' => $validatedData['file_type'],
                ];

                if ($request->filled('replacement_id')) {
                    $informasiToArchive = Informasi::find($request->replacement_id);
                    if ($informasiToArchive) {
                        if ($user->cannot('update', $informasiToArchive)) {
                            throw new AuthorizationException('Anda tidak diizinkan untuk mengubah dokumen milik unit kerja lain.');
                        }
                        $informasiToArchive->status = 'ARSIP';
                        $informasiToArchive->save();
                    }
                }
        
                $tanggal_dokumen = Carbon::parse($validatedData['tahun']);

                if ($request->input('file_type') === 'url') {
                    if ($informasi->file) {
                        Storage::disk('public')->delete($informasi->file);
                    }
                    $dataToUpdate['file'] = null;
                    $dataToUpdate['url'] = $validatedData['url'];
                } else {
                    if ($request->hasFile('file')) {
                        if ($informasi->file) {
                            Storage::disk('public')->delete($informasi->file);
                        }
                        $dataToUpdate['file'] = $this->storeFileWithCompression($request->file('file'));
                    }
                    if ($request->hasFile('file') || $request->input('url')) {
                        $dataToUpdate['url'] = null;
                    }
                }

                $dataToUpdate['tanggal_upload'] = $tanggal_dokumen->toDateString();
                $dataToUpdate['tahun'] = $tanggal_dokumen->format('Y');
                
                if ($isSuperAdmin) {
                    $dataToUpdate['unit_id'] = $request->target_unit;
                    $dataToUpdate['user_id'] = $user->id;
                } else {
                    // Ensure the user has a unit_id, fetch from API if not present
                    if (empty($user->unit_id) && !empty($user->nip)) {
                        $apiData = User::getDataFromApi($user->nip);
                        if ($apiData && !empty($apiData['unit_id'])) {
                            $user->unit_id = $apiData['unit_id'];
                            $user->save(); 
                        }
                    }
                    $dataToUpdate['unit_id'] = $user->unit_id;
                }

                $informasi->update($dataToUpdate);
            });
        } catch (AuthorizationException $e) {
            return redirect()->route('informasi-crud.edit', ['informasi' => $informasi->id])
                ->withInput($request->input())
                ->with('error', $e->getMessage());
        }


        Cache::forget('dip_years');

        $slug = \Illuminate\Support\Str::slug(str_replace('Informasi ', '', $validatedData['category']));
        return redirect()->route('frontend.informasi.category', ['category' => $slug])->with('success', '"' . $validatedData['title'] . '" berhasil diperbarui.');
    }

    /**
     * Store file with compression if it's an image
     */
    private function storeFileWithCompression($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());

        // Cek apakah file adalah gambar
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
            // Cek apakah ukuran file lebih dari 2MB
            if ($file->getSize() > 2 * 1024 * 1024) { // > 2MB
                $image = \Intervention\Image\Facades\Image::read($file->getRealPath());

                // Kompres gambar dengan kualitas 70% hingga ukurannya <= 2MB atau kualitas minimum 30%
                $quality = 70;
                $compressed = $image;

                // Coba berbagai kualitas hingga ukuran <= 2MB atau kualitas minimum 30%
                while ($quality > 30) {
                    $tempPath = storage_path('app/public/temp_' . uniqid() . '.' . $extension);
                    $compressed->save($tempPath, $quality);

                    if (filesize($tempPath) <= 2 * 1024 * 1024) { // <= 2MB
                        // Load file yang telah dikompresi sebelum disimpan
                        $compressedContent = file_get_contents($tempPath);
                        $filePath = 'files/' . time() . '_' . $file->getClientOriginalName();
                        \Storage::disk('public')->put($filePath, $compressedContent);
                        unlink($tempPath); // hapus file sementara
                        return $filePath;
                    }

                    unlink($tempPath); // hapus file sementara
                    $quality -= 10; // coba kualitas lebih rendah
                }

                // Jika tetap lebih dari 2MB, coba resize
                if ($quality <= 30) {
                    // Resize gambar (turunkan resolusi hingga <= 2MB)
                    $width = $image->width();
                    $height = $image->height();
                    $ratio = 0.8; // awalnya 80% dari ukuran asli

                    while ($ratio > 0.2) { // minimal 20% dari ukuran asli
                        $newWidth = (int)($width * $ratio);
                        $newHeight = (int)($height * $ratio);

                        $resized = $image->scale($newWidth, $newHeight);

                        $tempPath = storage_path('app/public/temp_' . uniqid() . '.' . $extension);
                        $resized->save($tempPath, 70);

                        if (filesize($tempPath) <= 2 * 1024 * 1024) { // <= 2MB
                            // Load file yang telah di-resize sebelum disimpan
                            $resizedContent = file_get_contents($tempPath);
                            $filePath = 'files/' . time() . '_' . $file->getClientOriginalName();
                            \Storage::disk('public')->put($filePath, $resizedContent);
                            unlink($tempPath); // hapus file sementara
                            return $filePath;
                        }

                        unlink($tempPath); // hapus file sementara
                        $ratio -= 0.1; // coba ukuran lebih kecil
                    }

                    // Jika tetap tidak berhasil, simpan dengan ukuran terakhir
                    $filePath = 'files/' . time() . '_' . $file->getClientOriginalName();
                    \Storage::disk('public')->put($filePath, $resized->encode());
                    return $filePath;
                }
            }

            // Jika file gambar < 2MB, tetap load dan simpan
            $filePath = 'files/' . time() . '_' . $file->getClientOriginalName();
            $originalContent = file_get_contents($file->getRealPath());
            \Storage::disk('public')->put($filePath, $originalContent);
            return $filePath;
        }

        // Untuk file non-gambar, load file sebelum disimpan
        $filePath = $file->store('files', 'public');
        return $filePath;
    }
    
    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $title = $informasi->title; // Simpan judul sebelum dihapus
        $categorySlug = \Illuminate\Support\Str::slug(str_replace('Informasi ', '', $informasi->category));

        DB::transaction(function () use ($informasi) {
            // Check if there is a related SubStandarLayanan and delete it
            if ($informasi->subStandarLayanan) {
                $informasi->subStandarLayanan->delete();
            }

            // Check if this Informasi record is linked to a StrukturOrganisasi
            if (Str::startsWith($informasi->content, 'struktur_organisasi_')) {
                $organizationId = (int) Str::after($informasi->content, 'struktur_organisasi_');
                $strukturOrganisasi = \App\Models\StrukturOrganisasi::where('organization_id', $organizationId)->first();

                if ($strukturOrganisasi) {
                    // Delete associated image file for StrukturOrganisasi if it exists
                    if ($strukturOrganisasi->image_path) {
                        Storage::disk('public')->delete($strukturOrganisasi->image_path);
                    }
                    $strukturOrganisasi->delete();
                }
            }

            // Delete associated file if it exists
            if ($informasi->file) {
                Storage::disk('public')->delete($informasi->file);
            }

            $informasi->delete();
        });

        Cache::forget('dip_years');

        return redirect()->route('frontend.informasi.category', ['category' => $categorySlug])->with('deleted', '"' . $title . '" berhasil dihapus.');
    }
}