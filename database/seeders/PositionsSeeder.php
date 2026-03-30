<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Bupati Sinjai',
                'slug' => 'bupati-sinjai',
                'is_single' => true,
            ],
            [
                'name' => 'Wakil Bupati Sinjai',
                'slug' => 'wakil-bupati-sinjai',
                'is_single' => true,
            ],
            [
                'name' => 'Sekretaris Daerah Sinjai',
                'slug' => 'sekretaris-daerah-sinjai',
                'is_single' => true,
            ],
            [
                'name' => 'Asisten I (Pemerintahan dan Kesra)',
                'slug' => 'asisten-i-pemerintahan-dan-kesra',
                'is_single' => true,
            ],
            [
                'name' => 'Asisten II (Perekonomian dan Pembangunan)',
                'slug' => 'asisten-ii-perekonomian-dan-pembangunan',
                'is_single' => true,
            ],
            [
                'name' => 'Asisten III (Administrasi Umum)',
                'slug' => 'asisten-iii-administrasi-umum',
                'is_single' => true,
            ],
            [
                'name' => 'Staf Ahli Bidang Politik, Hukum, dan Pemerintahan',
                'slug' => 'staf-ahli-bidang-politik-hukum-dan-pemerintahan',
                'is_single' => true,
            ],
            [
                'name' => 'Staf Ahli Bidang Ekonomi, Keuangan dan Pembangunan',
                'slug' => 'staf-ahli-bidang-ekonomi-keuangan-dan-pembangunan',
                'is_single' => true,
            ],
            [
                'name' => 'Staf Ahli Bidang Sosial dan Sumber Daya Manusia',
                'slug' => 'staf-ahli-bidang-sosial-dan-sumber-daya-manusia',
                'is_single' => true,
            ],
            [
                'name' => 'Kepala OPD',
                'slug' => 'kepala-opd',
                'is_single' => false, // Multiple Kepala OPD can exist for different organizations
            ],
        ];

        foreach ($positions as $position) {
            DB::table('positions')->updateOrInsert(
                ['slug' => $position['slug']],
                $position
            );
        }
    }
}