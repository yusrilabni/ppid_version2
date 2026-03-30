<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;

class GaleriController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $galeri = Galeri::orderBy('created_at', 'desc')
                            ->take(8)
                            ->get();

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
}
