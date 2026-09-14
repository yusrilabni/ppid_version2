<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;

class GaleriController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Galeri::orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');
            
            if ($request->has('limit')) {
                $galeri = $query->take((int)$request->get('limit'))->get();
                return response()->json($galeri);
            }

            $galeri = $query->paginate(12);
            return response()->json($galeri);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch galeri', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|string|max:255',
                'video' => 'nullable|string|max:255',
                'type' => 'required|string|in:foto,video', // Validate type to be 'foto' or 'video'
                'category' => 'nullable|string|max:255',
            ]);

            $galeri = Galeri::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'image' => $validatedData['image'] ?? null,
                'video' => $validatedData['video'] ?? null,
                'type' => $validatedData['type'],
                'category' => $validatedData['category'] ?? null,
            ]);

            return response()->json($galeri, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create galeri', 'message' => $e->getMessage()], 500);
        }
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
                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
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
