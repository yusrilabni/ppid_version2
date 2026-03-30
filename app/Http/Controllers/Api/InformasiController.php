<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Informasi;
use Illuminate\Http\JsonResponse;

class InformasiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $category = $request->query('category');

            $query = Informasi::where('published', true);

            if ($category) {
                $query->where('category', $category);
            }

            $informasi = $query->orderBy('created_at', 'desc')->get();

            return response()->json($informasi);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch informasi', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'category' => 'required|string|in:berkala,setiap-saat,dikecualikan', // Validate category
                'published' => 'boolean',
            ]);

            $informasi = Informasi::create([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'] ?? null,
                'category' => $validatedData['category'],
                'published' => $validatedData['published'] ?? false,
            ]);

            return response()->json($informasi, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create informasi', 'message' => $e->getMessage()], 500);
        }
    }
}
