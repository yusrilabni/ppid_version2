<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistik;
use Illuminate\Http\JsonResponse;

class StatistikController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $statistik = Statistik::orderBy('created_at', 'desc')->get();

            return response()->json($statistik);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch statistik', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'jumlah' => 'required|integer|min:0',
            ]);

            $statistik = Statistik::create([
                'nama' => $validatedData['nama'],
                'jumlah' => $validatedData['jumlah'],
            ]);

            return response()->json($statistik, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create statistik', 'message' => $e->getMessage()], 500);
        }
    }
}
