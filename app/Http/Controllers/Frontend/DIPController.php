<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Helpers\GeneralHelper;

use App\Exports\DipExport;
use Maatwebsite\Excel\Facades\Excel;

class DIPController extends Controller
{
    /**
     * Fetch unit data from the external API and cache it.
     */
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    /**
     * Redirect to the DIP of the latest year.
     */
    public function index()
    {
        $latestYear = Informasi::max('tahun');

        if (!$latestYear) {
            return view('frontend.pages.dip.no-data');
        }

        return redirect()->route('dip.show', $latestYear);
    }

    /**
     * Show the Daftar Informasi Publik (DIP) for a specific year.
     */
    public function show($year)
    {
        // 1. Get all *public* information for the current year, grouped by category
        $informasiTahunIni = Informasi::where('tahun', $year)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('status_keterbukaan', 'Terbuka')
            ->get()
            ->groupBy(['category', 'jenis_dokumen']);

        // Separate the 'Dikecualikan' category for the main list
        $informasiDikecualikan = Informasi::where('tahun', '>=', $year)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('category', 'Dikecualikan')
            ->get();

        // 2. Get updated information from the previous year
        $informasiPemutakhiran = Informasi::where('tahun', $year - 1)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->get();

        // 3. Get declassified information
        $informasiEksDikecualikan = Informasi::where('status_keterbukaan', 'Dikecualikan')
            ->where('tahun_berakhir_pengecualian', '<=', $year)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->get();

        // Check if any data exists for the given year to prevent empty pages
        if ($informasiTahunIni->isEmpty() && $informasiDikecualikan->isEmpty() && $informasiPemutakhiran->isEmpty() && $informasiEksDikecualikan->isEmpty()) {
            abort(404, 'Daftar Informasi Publik untuk tahun ' . $year . ' tidak ditemukan.');
        }

        // Get all unit data and create a map
        $allUnits = $this->getUnitData();
        
        return view('frontend.pages.dip.show', [
            'year' => $year,
            'informasiTahunIni' => $informasiTahunIni,
            'informasiDikecualikan' => $informasiDikecualikan,
            'informasiPemutakhiran' => $informasiPemutakhiran,
            'informasiEksDikecualikan' => $informasiEksDikecualikan,
            'unitMap' => $allUnits,
        ]);
    }

    /**
     * Export the Daftar Informasi Publik (DIP) for a specific year to Excel.
     */
    public function export($year)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Hanya Admin yang dapat mengekspor data ini.');
        }

        $informasiTahunIni = Informasi::where('tahun', $year)
            ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
            ->where('status_keterbukaan', 'Terbuka')
            ->get()
            ->groupBy(['category', 'jenis_dokumen', 'unit_id']);

        $allUnits = $this->getUnitData();

        $data = [
            'year' => $year,
            'informasiTahunIni' => $informasiTahunIni,
            'unitMap' => $allUnits,
        ];

        $fileName = 'DIP_KAB_SINJAI_' . $year . '.xlsx';

        return Excel::download(new DipExport($data), $fileName);
    }
}
