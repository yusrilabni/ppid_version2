<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $berita = Berita::where('published', true)
                            ->orderBy('created_at', 'desc')
                            ->take(6)
                            ->get();

            return response()->json($berita);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch berita', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'excerpt' => 'nullable|string|max:255',
                'image' => 'nullable|string|max:255',
                'published' => 'boolean',
            ]);

            // Generate slug if not provided or if title changes
            $slug = Str::slug($validatedData['title']);
            $count = 0;
            while (Berita::where('slug', $slug)->exists()) {
                $count++;
                $slug = Str::slug($validatedData['title']) . '-' . $count;
            }

            $berita = Berita::create([
                'title' => $validatedData['title'],
                'slug' => $slug,
                'content' => $validatedData['content'] ?? null,
                'excerpt' => $validatedData['excerpt'] ?? null,
                'image' => $validatedData['image'] ?? null,
                'published' => $validatedData['published'] ?? false,
            ]);

            return response()->json($berita, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create berita', 'message' => $e->getMessage()], 500);
        }
    }
}
