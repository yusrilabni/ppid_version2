<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection; // Add this line

class SummaryTotalExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithStyles // Add WithStyles here
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection([
            ['Total Informasi', $this->data['totalInformasi']],
            ['Total Permohonan', $this->data['totalPermohonan']],
            ['Total Respon Survei', $this->data['totalSurveyResponses']],
            ['Total Kunjungan', $this->data['totalVisits']],
            // 'totalPageViews' is currently 0 and might not be used, so omitting for now.
            ['Total Diunduh', $this->data['totalDownloads']],
        ]);
    }

    public function headings(): array
    {
        return [
            'Laporan',
            'Jumlah',
        ];
    }

    public function title(): string
    {
        return 'Ringkasan Laporan';
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styling to the header row
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFCCCCCC', // Light gray background
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Apply borders and text wrapping to all cells
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'wrapText' => true,
            ],
        ]);
    }
}
