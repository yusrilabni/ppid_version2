<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VillageOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai sinkronisasi Desa dan Kelurahan dari API...');

        try {
            // 1. Ambil Data Desa
            $this->command->info('Menarik data Desa...');
            $desaResponse = Http::timeout(15)->get('http://apps.sinjaikab.go.id/api/pegawai/get_wilayah?tipe=Desa');
            $desaData = $desaResponse->successful() ? $desaResponse->json() : [];

            // 2. Ambil Data Kelurahan
            $this->command->info('Menarik data Kelurahan...');
            $kelurahanResponse = Http::timeout(15)->get('http://apps.sinjaikab.go.id/api/pegawai/get_wilayah?tipe=Kelurahan');
            $kelurahanData = $kelurahanResponse->successful() ? $kelurahanResponse->json() : [];

            $allWilayah = array_merge($desaData, $kelurahanData);
            $count = 0;

            foreach ($allWilayah as $item) {
                $id = (string)$item['desa_id'];
                $nama = trim($item['desa_tipe'] . ' ' . $item['desa_nama']);
                $kecamatan = trim($item['kecamatan_nama']);
                
                // Buat slug unik (jika ada nama sama, tambahkan nama kecamatan)
                $slug = Str::slug($nama);
                $existingBySlug = Organization::where('slug', $slug)->where('remote_id', '!=', $id)->first();
                if ($existingBySlug) {
                    $slug = Str::slug($nama . ' ' . $kecamatan);
                }

                // Gunakan updateOrCreate agar tidak duplikat berdasarkan remote_id
                Organization::updateOrCreate(
                    ['remote_id' => $id],
                    [
                        'name' => $nama,
                        'slug' => $slug,
                        'type' => 'unit',
                        'status' => 'active',
                        'unit_id' => $id,
                        'remote_id' => $id,
                    ]
                );
                $count++;
            }

            $this->command->info("Berhasil memasukkan/memperbarui $count data Desa & Kelurahan.");

        } catch (\Exception $e) {
            $this->command->error('Gagal mengambil data dari API: ' . $e->getMessage());
        }
    }
}
