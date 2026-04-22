<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\JsonResponse;

class BeritaController extends Controller {
    public function index(): JsonResponse {
        $berita = Berita::where("status", "PUBLISH")->latest()->paginate(10);
        return response()->json(["success" => true, "data" => $berita]);
    }
    public function show($slug): JsonResponse {
        $berita = Berita::where("slug", $slug)->first();
        if (!$berita) return response()->json(["success" => false, "message" => "Berita tidak ditemukan"], 404);
        return response()->json(["success" => true, "data" => $berita]);
    }
}
