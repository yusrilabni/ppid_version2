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
    public function list()
    {
        try {
            $organizations = Organization::all();
            return response()->json([
                'success' => true,
                'data' => $organizations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        $organizations = Organization::all()->keyBy('remote_id');
        
        $opds = [];
        $kecamatans = [];
        $villagesByKecamatan = [];
        
        // 1. Ambil Data Dasar dari API (OPD & Kecamatan)
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
                
                // Deteksi kecamatan lebih fleksibel (via type atau nama)
                $isKecUnit = ($org && $org->type === 'kecamatan') || stripos($unit['unit_nama'], 'Kecamatan') !== false;
                
                if ($isKecUnit) {
                    $kecamatans[$id] = $data;
                } else {
                    $opds[$id] = $data;
                }
            }
        }
        
        // 2. Ambil Data Desa/Kelurahan dan Kelompokkan Berdasarkan Kecamatan
        if (!empty($cached['villages_grouped'])) {
            foreach ($cached['villages_grouped'] as $kecName => $villages) {
                $villagesByKecamatan[$kecName] = [];
                foreach ($villages as $village) {
                    $vId = (string)$village['desa_id'];
                    $vName = $village['desa_tipe'] . ' ' . $village['desa_nama'];
                    $vOrg = $organizations->get($vId);
                    
                    // Fallback slug detection
                    if (!$vOrg) {
                        $potentialSlug = \Illuminate\Support\Str::slug($vName);
                        $vOrg = $organizations->where('slug', $potentialSlug)->first();
                    }

                    $villagesByKecamatan[$kecName][] = [
                        'unit_id' => $vId,
                        'name' => $vName,
                        'slug' => $vOrg ? $vOrg->slug : null,
                        'type' => $village['desa_tipe']
                    ];
                }
            }
        }

        // Sort data
        uasort($opds, fn($a, $b) => strcasecmp($a['name'], $b['name']));
        uasort($kecamatans, fn($a, $b) => strcasecmp($a['name'], $b['name']));
        ksort($villagesByKecamatan);

        if (request()->is('api/*') || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'opds' => array_values($opds),
                    'kecamatans' => array_values($kecamatans),
                    'villagesByKecamatan' => $villagesByKecamatan
                ]
            ]);
        }

        return view('frontend.opd.list_dip', compact('opds', 'kecamatans', 'villagesByKecamatan'));
    }

    /**
     * Show the DIP for a specific OPD with year filtering.
     */
    public function opdDip(Request $request, Organization $organization)
    {
        $remoteId = (string)$organization->remote_id;
        $isKecamatan = $organization->type === 'kecamatan' || stripos($organization->name, 'Kecamatan') !== false;
        
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        $childUnitIds = [$remoteId];

        if ($isKecamatan) {
            if (!empty($cached['villages_grouped'])) {
                foreach ($cached['villages_grouped'] as $groupName => $villages) {
                    // Cari apakah nama grup (Bulupoddo) ada di dalam nama organisasi (Kantor Kecamatan Bulupoddo)
                    // atau sebaliknya.
                    if (stripos($organization->name, trim($groupName)) !== false || stripos($groupName, trim($organization->name)) !== false) {
                        \Illuminate\Support\Facades\Log::info("Match found for Kecamatan: " . $groupName);
                        foreach ($villages as $v) {
                            $childUnitIds[] = (string)$v['desa_id'];
                        }
                        break;
                    }
                }
            }
        }

        \Illuminate\Support\Facades\Log::info("Unit IDs to search: " . implode(', ', $childUnitIds));

        $unitFilter = function($query) use ($childUnitIds) {
            $query->whereIn('unit_id', $childUnitIds);
        };

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
        $informasiTahunIniRaw = Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('tahun', $year)
            ->where(function($query) use ($unitFilter) {
                $unitFilter($query);
            })
            ->get();

        $unitData = collect($this->getUnitData());

        // Map names before grouping to ensure accuracy and clean names
        $informasiTahunIniRaw->each(function($item) use ($unitData) {
            $rawName = $unitData->get($item->unit_id)['unit_nama'] ?? 'Unit Tidak Terdaftar';
            // Bersihkan nama dari "(Kec. ...)" agar tidak redundan
            $item->unit_display_name = trim(preg_replace('/\s*\(Kec\..*?\)\s*/i', '', $rawName));
        });

        // Group by Category -> Jenis Dokumen -> Unit Name
        $informasiTahunIni = $informasiTahunIniRaw->groupBy(['category', 'jenis_dokumen', 'unit_display_name']);
        $unitName = $unitData->get($remoteId)['unit_nama'] ?? $organization->name;

        if (request()->is('api/*') || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'organization' => $organization,
                    'year' => $year,
                    'availableYears' => $availableYears,
                    'informasiTahunIni' => $informasiTahunIni,
                    'unitName' => $unitName
                ]
            ]);
        }

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
        
        $cached = GeneralHelper::syncExternalUnitsIfNeeded();
        $childUnitIds = [$remoteId];

        if ($isKecamatan) {
            if (!empty($cached['villages_grouped'])) {
                foreach ($cached['villages_grouped'] as $groupName => $villages) {
                    if (stripos($organization->name, trim($groupName)) !== false || stripos($groupName, trim($organization->name)) !== false) {
                        foreach ($villages as $v) {
                            $childUnitIds[] = (string)$v['desa_id'];
                        }
                        break;
                    }
                }
            }
        }

        $unitFilter = function($query) use ($childUnitIds) {
            $query->whereIn('unit_id', $childUnitIds);
        };

        $year = $request->get('year', Informasi::where(function($query) use ($unitFilter) {
            $unitFilter($query);
        })->max('tahun') ?: date('Y'));
        
        // Get information
        $informasiTahunIniRaw = Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('tahun', $year)
            ->where(function($query) use ($unitFilter) {
                $unitFilter($query);
            })
            ->get();

        $unitData = collect($this->getUnitData());

        // Map names before grouping to ensure accuracy and clean names
        $informasiTahunIniRaw->each(function($item) use ($unitData) {
            $rawName = $unitData->get($item->unit_id)['unit_nama'] ?? 'Unit Tidak Terdaftar';
            // Bersihkan nama dari "(Kec. ...)" agar tidak redundan
            $item->unit_display_name = trim(preg_replace('/\s*\(Kec\..*?\)\s*/i', '', $rawName));
        });

        // Group by Category -> Jenis Dokumen -> Unit Name
        $informasiTahunIni = $informasiTahunIniRaw->groupBy(['category', 'jenis_dokumen', 'unit_display_name']);
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
