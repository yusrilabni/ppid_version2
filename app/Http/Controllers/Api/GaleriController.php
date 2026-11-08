<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GaleriController extends Controller
{
    /**
     * Public listing of galeri (Hanya menampilkan galeri public)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Galeri::query();

            // Default publik: hanya tampilkan yang public (atau null untuk backward compatibility)
            $query->where(function ($q) {
                $q->whereNull('visibility')->orWhere('visibility', 'public');
            });

            if ($request->filled('type') && in_array($request->type, ['foto', 'video'])) {
                $query->where('type', $request->type);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $query->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');

            if ($request->has('limit')) {
                $galeri = $query->take((int)$request->get('limit'))->get();
                return response()->json($galeri);
            }

            $galeri = $query->paginate((int)$request->get('per_page', 12));
            return response()->json($galeri);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch galeri', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Admin listing of galeri (Bisa melihat semua, termasuk private)
     */
    public function adminIndex(Request $request): JsonResponse
    {
        try {
            $query = Galeri::with('user:id,name');

            // Filter visibility jika diminta (all, public, private)
            if ($request->filled('visibility') && in_array($request->visibility, ['public', 'private'])) {
                $query->where('visibility', $request->visibility);
            }

            // Filter type
            if ($request->filled('type') && in_array($request->type, ['foto', 'video'])) {
                $query->where('type', $request->type);
            }

            // Search query
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $query->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');

            $perPage = (int)$request->get('per_page', 12);
            $galeri = $query->paginate($perPage);

            return response()->json($galeri);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat galeri admin', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show single galeri detail
     */
    public function show($id): JsonResponse
    {
        try {
            $galeri = Galeri::with('user:id,name')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $galeri
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Galeri tidak ditemukan', 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Store new galeri from API/Nuxt client
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|string|in:foto,video',
                'visibility' => 'nullable|string|in:public,private',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'video' => 'nullable|url|max:255',
                'category' => 'nullable|string|max:255',
                'jenis_dokumen' => 'nullable|string|max:255',
                'tanggal_upload' => 'nullable|date',
                'is_pinned' => 'nullable|boolean',
            ]);

            $imagePathFinal = null;
            if ($request->type === 'foto' && $request->hasFile('image')) {
                $imagePathFinal = $this->processAndStoreImage($request->file('image'));
            }

            $galeri = Galeri::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'image' => $imagePathFinal,
                'video' => $validatedData['type'] === 'video' ? ($validatedData['video'] ?? null) : null,
                'type' => $validatedData['type'],
                'visibility' => $validatedData['visibility'] ?? 'public',
                'category' => $validatedData['category'] ?? null,
                'jenis_dokumen' => $validatedData['jenis_dokumen'] ?? null,
                'tanggal_upload' => $validatedData['tanggal_upload'] ?? now()->toDateString(),
                'is_pinned' => filter_var($request->input('is_pinned', false), FILTER_VALIDATE_BOOLEAN),
                'user_id' => Auth::id(),
            ]);

            Cache::forget('all_home');

            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil ditambahkan',
                'data' => $galeri
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat galeri', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update galeri from API/Nuxt client
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $galeri = Galeri::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|string|in:foto,video',
                'visibility' => 'nullable|string|in:public,private',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'video' => 'nullable|url|max:255',
                'category' => 'nullable|string|max:255',
                'jenis_dokumen' => 'nullable|string|max:255',
                'tanggal_upload' => 'nullable|date',
                'is_pinned' => 'nullable|boolean',
            ]);

            $imagePathFinal = $galeri->image;

            if ($request->type === 'foto' && $request->hasFile('image')) {
                // Delete old image if exists
                if ($galeri->image && Storage::disk('public')->exists($galeri->image)) {
                    Storage::disk('public')->delete($galeri->image);
                }
                $imagePathFinal = $this->processAndStoreImage($request->file('image'));
            }

            $galeri->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'image' => $request->type === 'foto' ? $imagePathFinal : null,
                'video' => $request->type === 'video' ? ($validatedData['video'] ?? null) : null,
                'type' => $validatedData['type'],
                'visibility' => $validatedData['visibility'] ?? $galeri->visibility ?? 'public',
                'category' => $validatedData['category'] ?? null,
                'jenis_dokumen' => $validatedData['jenis_dokumen'] ?? null,
                'tanggal_upload' => $validatedData['tanggal_upload'] ?? $galeri->tanggal_upload ?? now()->toDateString(),
                'is_pinned' => $request->has('is_pinned') ? filter_var($request->input('is_pinned'), FILTER_VALIDATE_BOOLEAN) : $galeri->is_pinned,
            ]);

            Cache::forget('all_home');

            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil diperbarui',
                'data' => $galeri
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui galeri', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete galeri
     */
    public function destroy($id): JsonResponse
    {
        try {
            $galeri = Galeri::findOrFail($id);

            if ($galeri->image && Storage::disk('public')->exists($galeri->image)) {
                Storage::disk('public')->delete($galeri->image);
            }

            $galeri->delete();
            Cache::forget('all_home');

            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus galeri', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Toggle pinned status
     */
    public function togglePin($id): JsonResponse
    {
        try {
            $galeri = Galeri::findOrFail($id);
            $galeri->update([
                'is_pinned' => !$galeri->is_pinned
            ]);

            Cache::forget('all_home');

            return response()->json([
                'success' => true,
                'message' => $galeri->is_pinned ? 'Galeri disematkan di posisi teratas' : 'Penyematan galeri dilepas',
                'is_pinned' => $galeri->is_pinned
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengubah status pin', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Helper to process image and store as WebP
     */
    protected function processAndStoreImage($imageFile): string
    {
        ini_set('memory_limit', '512M');
        $imageManager = new ImageManager(new Driver());
        $imageInstance = $imageManager->read($imageFile->path());

        $quality = 80;
        $imageInstance = $imageInstance->toWebp($quality);

        $tempPath = tempnam(sys_get_temp_dir(), 'galeri_') . '.webp';
        $imageInstance->save($tempPath);

        while (filesize($tempPath) > 2 * 1024 * 1024 && $quality > 20) {
            $quality -= 10;
            $imageInstance = $imageManager->read($imageFile->path())->toWebp($quality);
            $imageInstance->save($tempPath);
        }

        $baseName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = str_replace(' ', '_', $baseName) . '_' . time() . '.webp';
        $imagePathFinal = 'galeri/' . $fileName;

        Storage::disk('public')->put($imagePathFinal, file_get_contents($tempPath));
        @unlink($tempPath);

        return $imagePathFinal;
    }

    public function download($id)
    {
        try {
            $galeri = Galeri::findOrFail($id);
            if (!$galeri->image) {
                return response()->json(['error' => 'No image found'], 404);
            }

            $path = storage_path('app/public/' . $galeri->image);
            if (!file_exists($path)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $filename = 'Galeri_PPID_' . \Illuminate\Support\Str::slug($galeri->title ?: 'Foto');

            if ($extension === 'webp') {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($path);
                
                $encoded = $image->toJpeg(90);
                
                return response((string) $encoded)
                    ->header('Content-Type', 'image/jpeg')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '.jpg"');
            }

            return response()->download($path, $filename . '.' . $extension);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Download failed', 'message' => $e->getMessage()], 500);
        }
    }
}
