<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use App\Models\Statistik;
use Carbon\Carbon;

class VisitorDetailExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithStyles // Add WithStyles here
{
    protected $startDate;
    protected $endDate;

    public function __construct(Carbon $startDate = null, Carbon $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Re-use the aggregation logic from ReportController
        return Statistik::when($this->startDate, function ($query) {
                                return $query->whereDate('nama', '>=', $this->startDate); // 'nama' column stores the date
                            })
                            ->when($this->endDate, function ($query) {
                                return $query->whereDate('nama', '<=', $this->endDate->endOfDay()); // 'nama' column stores the date
                            })
                            ->selectRaw('nama as report_date, SUM(jumlah) as visitors_count') // Assuming 'jumlah' is total visits for the day
                            ->groupBy('nama')
                            ->orderBy('nama', 'asc')
                            ->get()
                            ->map(function ($visitor) {
                                return [
                                    Carbon::parse($visitor->report_date)->format('d M Y'),
                                    $visitor->visitors_count,
                                    // 'views_count' is not directly tracked in Statistik model based on previous findings.
                                    // If needed, it would require a separate tracking mechanism.
                                    // For now, we only export what's available (total visits for the day).
                                ];
                            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jumlah Kunjungan',
        ];
    }

    public function title(): string
    {
        return 'Pengunjung Detail';
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
