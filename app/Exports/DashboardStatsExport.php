<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles; // Added
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Added
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Added

class DashboardStatsExport implements FromArray, WithHeadings, WithTitle, WithStyles, ShouldAutoSize // Added concerns
{
    protected $dashboardStats;

    private $translationMap = [
        'totalInformasiCount' => 'Total Informasi',
        'totalPermohonanCount' => 'Total Permohonan Informasi',
        'totalSurveyResponses' => 'Total Respon Survei',
        'totalVisits' => 'Total Kunjungan',
        'totalPageViews' => 'Total Dilihat (Page Views)',
        'totalDownloads' => 'Total Unduhan',
        'totalUsers' => 'Total Pengguna',
        'totalOrganizations' => 'Total Organisasi',
        'totalOfficials' => 'Total Pejabat',
        'totalSliders' => 'Total Sliders',
        'totalGaleri' => 'Total Galeri',
        'totalSubStandarLayanan' => 'Total Sub Standar Layanan',
        'totalLaporan' => 'Total Laporan',
    ];

    public function __construct(array $dashboardStats)
    {
        $this->dashboardStats = $dashboardStats;
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->dashboardStats as $key => $value) {
            $name = $this->translationMap[$key] ?? ucwords(str_replace(['Count', '_'], ['', ' '], preg_replace('/(?<!^)[A-Z]/', ' $0', $key)));
            $data[] = [$name, $value];
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Statistik',
            'Nilai',
        ];
    }

    public function title(): string
    {
        return 'Statistik Laporan';
    }

    // Implement WithStyles concern
    public function styles(Worksheet $sheet)
    {
        // Apply bold and background to header row
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE0E0E0']], // Light grey background
        ]);

        // Apply borders to all data rows
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}
