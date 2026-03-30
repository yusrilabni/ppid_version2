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
     * Display a list of OPDs that have participated in uploading information.
     */
    public function index()
    {
        // Get all unique unit_ids that have uploaded information
        $participatingUnitIds = Informasi::whereNotNull('unit_id')
            ->distinct()
            ->pluck('unit_id')
            ->toArray();

        // Fetch organizations matching these unit_ids
        $organizations = Organization::whereIn('remote_id', $participatingUnitIds)
            ->with('strukturOrganisasi.informasi')
            ->get();

        $unitData = collect($this->getUnitData());

        // Map API data to organizations
        $organizations->each(function ($organization) use ($unitData) {
            $matchingUnit = $unitData->get($organization->remote_id);
            if ($matchingUnit) {
                $organization->api_address = (empty($matchingUnit['unit_alamat']) || $matchingUnit['unit_alamat'] === '0') 
                    ? 'Alamat belum ditambahkan' 
                    : $matchingUnit['unit_alamat'];
            } else {
                $organization->api_address = 'Alamat belum ditambahkan';
            }
        });

        return view('frontend.opd.list', compact('organizations'));
    }

    /**
     * Show the DIP for a specific OPD with year filtering.
     */
    public function opdDip(Request $request, Organization $organization)
    {
        $year = $request->get('year', Informasi::where('unit_id', $organization->remote_id)->max('tahun') ?: date('Y'));
        
        // Get available years for this OPD
        $availableYears = Informasi::where('unit_id', $organization->remote_id)
            ->whereNotNull('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Get information for this OPD and year
        $informasiTahunIni = Informasi::where('unit_id', $organization->remote_id)
            ->where('tahun', $year)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('status_keterbukaan', 'Terbuka')
            ->get()
            ->groupBy(['category', 'jenis_dokumen']);

        $unitData = collect($this->getUnitData());
        $unitName = $unitData->get($organization->remote_id)['unit_nama'] ?? $organization->name;

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

        $year = $request->get('year', Informasi::where('unit_id', $organization->remote_id)->max('tahun') ?: date('Y'));
        
        // Get information for this OPD and year
        $informasiTahunIni = Informasi::where('unit_id', $organization->remote_id)
            ->where('tahun', $year)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('status_keterbukaan', 'Terbuka')
            ->get()
            ->groupBy(['category', 'jenis_dokumen']);

        $unitData = collect($this->getUnitData());
        $unitName = $unitData->get($organization->remote_id)['unit_nama'] ?? $organization->name;

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
