<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StandarLayanan;
use App\Http\Controllers\Controller;

class StandarLayananController extends Controller
{
    public function index()
    {
        $menuConfig = config('menu');
        $standarLayananMenu = collect($menuConfig)->firstWhere('title', 'Standar Layanan');
        $standarLayananItems = [];

        if ($standarLayananMenu && !empty($standarLayananMenu['children'])) {
            foreach ($standarLayananMenu['children'] as $menuItem) {
                // Find or create the main item in the database to ensure it exists
                $layanan = StandarLayanan::firstOrCreate(
                    ['title' => $menuItem['title']],
                    ['category' => 'standar-layanan'] 
                );

                // Eager load the sub-items
                $layanan->load('subStandarLayanans');
                $standarLayananItems[] = $layanan;
            }
        }

        return view('admin.standar-layanan.index', ['standarLayanans' => $standarLayananItems]);
    }
}
