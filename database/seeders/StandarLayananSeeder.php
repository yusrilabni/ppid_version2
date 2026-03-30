<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\StandarLayanan;

class StandarLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use the model to delete
        StandarLayanan::query()->delete();

        $categories = [
            'Dasar Hukum',
            'Tugas, Wewenang & Tanggung Jawab',
            'SOP',
            'Maklumat Pelayanan',
            'Mekanisme & Biaya',
        ];

        foreach ($categories as $category) {
            // Use the model to create
            StandarLayanan::create([
                'title' => $category,
                'category' => Str::slug($category),
                'content' => 'Konten untuk ' . $category,
                'published' => true,
            ]);
        }
    }
}