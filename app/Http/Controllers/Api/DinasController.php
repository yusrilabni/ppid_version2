<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Informasi;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Exports\DipExport;
use Maatwebsite\Excel\Facades\Excel;

class DinasController extends Controller
{
    /**
     * Display a list of units (OPD & Kecamatan) that have participated in uploading information.
     */
    public function index()
    {
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        $organizations = Organization::all()->keyBy('remote_id');
        
        $opds = [];
        $kecamatans = [];
        
        // Handle OPDs and Kecamatans (from cached units)
        if (!empty($cached['units'])) {
            foreach ($cached['units'] as $unit) {
                $id = (string)$unit['unit_id'];
                $org = $organizations->get($id);
                
                $data = [
                    'unit_id' => $id,
                    'name' => $unit['unit_nama'],
                    'slug' => $org ? $org->slug : null,
                    'address' => (empty($unit['unit_alamat']) || $unit['unit_alamat'] === '0') 
                        ? 'Alamat belum ditambahkan' 
                        : $unit['unit_alamat'],
                    'website_url' => $org ? $org->website_url : null,
                ];
                
                if ($org && $org->type === 'kecamatan') {
                    $kecamatans[$id] = $data;
                    $kecamatans[$id]['villages'] = [];
                } else {
                    $opds[$id] = $data;
                }
            }
        }
        
        // Handle Villages/Desa (from cached villages_grouped)
        if (!empty($cached['villages_grouped'])) {
            foreach ($cached['villages_grouped'] as $kecName => $villages) {
                // Pre-calculate potential kecamatan IDs for this group name
                $targetKecId = null;
                $trimmedKecName = trim(str_ireplace('Kecamatan', '', $kecName));
                
                foreach ($kecamatans as $id => $kec) {
                    if (stripos($kec['name'], $trimmedKecName) !== false) {
                        $targetKecId = $id;
                        break;
                    }
                }

                foreach ($villages as $village) {
                    $vId = (string)$village['desa_id'];
                    $vName = $village['desa_tipe'] . ' ' . $village['desa_nama'];
                    
                    // Coba cari organisasi berdasarkan remote_id
                    $vOrg = $organizations->get($vId);
                    
                    // Fallback: Jika tidak ketemu by remote_id, coba cari by name slug
                    if (!$vOrg) {
                        $potentialSlug = \Illuminate\Support\Str::slug($vName);
                        $vOrg = $organizations->where('slug', $potentialSlug)->first();
                    }

                    $vData = [
                        'unit_id' => $vId,
                        'name' => $vName,
                        'slug' => $vOrg ? $vOrg->slug : null,
                        'type' => 'WILAYAH'
                    ];

                    // Penentuan Grup Kecamatan
                    $kecIdFromVillage = substr($vId, 0, 6);
                    
                    if (isset($kecamatans[$kecIdFromVillage])) {
                        $kecamatans[$kecIdFromVillage]['villages'][] = $vData;
                    } elseif ($targetKecId) {
                        // Jika ID tidak cocok tapi nama Kecamatan grup dari API cocok dengan salah satu Kecamatan di list
                        $kecamatans[$targetKecId]['villages'][] = $vData;
                    } else {
                        // Jika tetap tidak ketemu, masukkan ke 'Lainnya'
                        if (!isset($kecamatans['other'])) {
                            $kecamatans['other'] = [
                                'name' => 'Wilayah Lainnya',
                                'slug' => null,
                                'address' => '',
                                'villages' => []
                            ];
                        }
                        $kecamatans['other']['villages'][] = $vData;
                    }
                }
            }
        }

        // Sort OPDs by name
        uasort($opds, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });

        // Sort Kecamatans by name
        uasort($kecamatans, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });

        return view('frontend.opd.list_dip', compact('opds', 'kecamatans'));
    }

    /**
     * Show the DIP for a specific OPD with year filtering.
     */
    public function opdDip(Request $request, Organization $organization)
    {
        $remoteId = (string)$organization->remote_id;
        // Deteksi kecamatan lebih fleksibel (via type atau nama)
        $isKecamatan = $organization->type === 'kecamatan' || stripos($organization->name, 'Kecamatan') !== false;
        
        \Illuminate\Support\Facades\Log::info("Checking DIP for: " . $organization->name . " | ID: " . $remoteId . " | IsKecamatan: " . ($isKecamatan ? 'Yes' : 'No'));

        $unitFilter = function($query) use ($remoteId, $isKecamatan) {
            if ($isKecamatan) {
                $query->where(function($q) use ($remoteId) {
                    $q->where('unit_id', $remoteId)
                      ->orWhere('unit_id', 'LIKE', $remoteId . '%');
                });
            } else {
                $query->where('unit_id', $remoteId);
            }
        };

        // DEBUG: Cek total data tanpa filter apapun
        $totalData = Informasi::where(function($query) use ($unitFilter) { $unitFilter($query); })->count();
        \Illuminate\Support\Facades\Log::info("Total documents found for this unit (all years/status): " . $totalData);

        $year = $request->get('year', Informasi::where(function($query) use ($unitFilter) {
            $unitFilter($query);
        })->max('tahun') ?: date('Y'));
        
        // Get available years
        $availableYears = Informasi::where(function($query) use ($unitFilter) {
            $unitFilter($query);
        })
            ->whereNotNull('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Get information
        $informasiTahunIni = Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('tahun', $year)
            ->where(function($query) use ($unitFilter) {
                $unitFilter($query);
            })
            ->get()
            ->groupBy(['category', 'jenis_dokumen']);

        $unitData = collect($this->getUnitData());
        $unitName = $unitData->get($remoteId)['unit_nama'] ?? $organization->name;

        return view('frontend.opd.dip', [
            'organization' => $organization,
            'year' => $year,
            'availableYears' => $availableYears,
            'informasiTahunIni' => $informasiTahunIni,
            'unitName' => $unitName,
            'unitMap' => $unitData,
        ]);
    }

    /**
     * Export the DIP for a specific OPD to Excel.
     */
    public function export(Request $request, Organization $organization)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Hanya Admin yang dapat mengekspor data ini.');
        }

        $remoteId = (string)$organization->remote_id;
        $isKecamatan = $organization->type === 'kecamatan' || stripos($organization->name, 'Kecamatan') !== false;
        
        $unitFilter = function($query) use ($remoteId, $isKecamatan) {
            if ($isKecamatan) {
                $query->where(function($q) use ($remoteId) {
                    $q->where('unit_id', $remoteId)
                      ->orWhere('unit_id', 'LIKE', $remoteId . '%');
                });
            } else {
                $query->where('unit_id', $remoteId);
            }
        };

        $year = $request->get('year', Informasi::where(function($query) use ($unitFilter) {
            $unitFilter($query);
        })->max('tahun') ?: date('Y'));
        
        // Get information
        $informasiTahunIni = Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('tahun', $year)
            ->where(function($query) use ($unitFilter) {
                $unitFilter($query);
            })
            ->get()
            ->groupBy(['category', 'jenis_dokumen']);

        $unitData = collect($this->getUnitData());
        $unitName = $unitData->get($remoteId)['unit_nama'] ?? $organization->name;

        $data = [
            'year' => $year,
            'informasiTahunIni' => $informasiTahunIni,
            'unitName' => $unitName,
            'unitMap' => $unitData,
        ];

        $fileName = 'DIP_' . strtoupper(str_replace(' ', '_', $unitName)) . '_' . $year . '.xlsx';

        return Excel::download(new DipExport($data), $fileName);
    }

    /**
     * Fetch unit data from helper.
     */
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }
}
