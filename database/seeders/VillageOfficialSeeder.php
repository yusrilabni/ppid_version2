<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Official;
use App\Models\Position;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VillageOfficialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai pembuatan data pimpinan Desa & Kelurahan...');

        $kepalaOpdPosition = Position::where('slug', 'kepala-opd')->first();

        if (!$kepalaOpdPosition) {
            $this->command->error('Posisi "Kepala OPD" tidak ditemukan. Jalankan PositionsSeeder terlebih dahulu.');
            return;
        }

        // Ambil semua organisasi yang merupakan Desa atau Kelurahan
        $organizations = Organization::where('name', 'LIKE', 'Desa %')
            ->orWhere('name', 'LIKE', 'Kelurahan %')
            ->get();

        $count = 0;
        foreach ($organizations as $org) {
            $fullName = 'Kepala ' . $org->name;
            
            // Cek apakah sudah ada pejabat di organisasi ini
            $exists = Official::where('organization_id', $org->id)->exists();

            if (!$exists) {
                // Generate unique slug
                $slug = Str::slug($fullName);
                $originalSlug = $slug;
                $i = 1;
                while (Official::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $i++;
                }

                Official::create([
                    'full_name' => $fullName,
                    'slug' => $slug,
                    'position_id' => $kepalaOpdPosition->id,
                    'organization_id' => $org->id,
                    'status' => 'draft', // Set as draft so it can be edited later
                    'status_jabatan' => 'Definitif'
                ]);
                $count++;
            }
        }

        $this->command->info("Berhasil membuat $count placeholder profil pimpinan Desa & Kelurahan.");
    }
}
