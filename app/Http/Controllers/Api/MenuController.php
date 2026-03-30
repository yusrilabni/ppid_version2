<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $menus = Menu::where('active', true)
                         ->orderBy('order', 'asc')
                         ->get();

            return response()->json($menus);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch menus', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'url' => 'nullable|string|max:255',
                'parent_id' => 'nullable|exists:menus,id', // Validate parent_id exists in menus table
                'order' => 'integer|min:0',
                'active' => 'boolean',
            ]);

            $menu = Menu::create([
                'title' => $validatedData['title'],
                'url' => $validatedData['url'] ?? null,
                'parent_id' => $validatedData['parent_id'] ?? null,
                'order' => $validatedData['order'] ?? 0,
                'active' => $validatedData['active'] ?? true,
            ]);

            return response()->json($menu, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create menu', 'message' => $e->getMessage()], 500);
        }
    }
}
