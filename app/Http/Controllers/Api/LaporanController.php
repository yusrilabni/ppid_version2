<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Http\JsonResponse;

class LaporanController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $laporan = Laporan::where('published', true)
                              ->orderBy('tahun', 'desc')
                              ->get()
                              ->map(function($item) {
                                  $item->encoded_id = strtoupper(base_convert(($item->id + 100000000) * 7, 10, 36));
                                  return $item;
                              });

            return response()->json($laporan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch laporan', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'type' => 'required|string|in:ppid,survei,permohonan', // Validate type
                'file' => 'nullable|string|max:255',
                'published' => 'boolean',
            ]);

            $laporan = Laporan::create([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'] ?? null,
                'type' => $validatedData['type'],
                'file' => $validatedData['file'] ?? null,
                'published' => $validatedData['published'] ?? false,
            ]);

            return response()->json($laporan, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create laporan', 'message' => $e->getMessage()], 500);
        }
    }
}
