<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\SubStandarLayanan;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
    public function index(): JsonResponse {
        $categories = SubStandarLayanan::with("standarLayanan")->get();
        return response()->json(["success" => true, "data" => $categories]);
    }
}
