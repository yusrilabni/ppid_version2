<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $sliders = Slider::where('active', true)
                             ->orderBy('order', 'asc')
                             ->get();

            return response()->json($sliders);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch sliders', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|string|max:255',
                'link' => 'nullable|string|max:255',
                'order' => 'integer|min:0',
                'active' => 'boolean',
            ]);

            $slider = Slider::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'image' => $validatedData['image'],
                'link' => $validatedData['link'] ?? null,
                'order' => $validatedData['order'] ?? 0,
                'active' => $validatedData['active'] ?? true,
            ]);

            return response()->json($slider, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create slider', 'message' => $e->getMessage()], 500);
        }
    }
}
