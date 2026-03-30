<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Berita;
use App\Models\Slider;
use App\Models\Galeri;
use App\Models\Statistik;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $user = Auth::user();

            // Ensure only admin can access
            if (!$user || $user->role !== 'admin') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $beritaCount = Berita::count();
            $sliderCount = Slider::count();
            $galeriCount = Galeri::count();
            $statistikCount = Statistik::count();
            $publishedBeritaCount = Berita::where('published', true)->count();
            $activeSliderCount = Slider::where('active', true)->count();
            $fotoGaleriCount = Galeri::where('type', 'foto')->count();
            $videoGaleriCount = Galeri::where('type', 'video')->count();

            $stats = [
                'berita' => [
                    'total' => $beritaCount,
                    'published' => $publishedBeritaCount,
                    'draft' => $beritaCount - $publishedBeritaCount,
                ],
                'slider' => [
                    'total' => $sliderCount,
                    'active' => $activeSliderCount,
                ],
                'galeri' => [
                    'total' => $galeriCount,
                    'foto' => $fotoGaleriCount,
                    'video' => $videoGaleriCount,
                ],
                'statistik' => $statistikCount,
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch dashboard stats', 'message' => $e->getMessage()], 500);
        }
    }
}
