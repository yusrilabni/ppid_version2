<?php

namespace App\Exports;

use App\Models\Statistik;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection; // Add this line

class VisitorReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles // Add WithStyles here
{
    protected $startDate;
    protected $endDate;

    public function __construct(string $startDate = null, string $endDate = null)
    {
        $this->startDate = $startDate; // Keep as string for query
        $this->endDate = $endDate;   // Keep as string for query
    }

    public function collection()
    {
        $startDateParsed = $this->startDate ? Carbon::parse($this->startDate) : null;
        $endDateParsed = $this->endDate ? Carbon::parse($this->endDate) : null;

        $visitorData = Statistik::when($startDateParsed, function ($query) use ($startDateParsed) {
                                return $query->where('created_at', '>=', $startDateParsed);
                            })
                            ->when($endDateParsed, function ($query) use ($endDateParsed) {
                                return $query->where('created_at', '<=', $endDateParsed->endOfDay());
                            })
                            ->selectRaw('DATE(created_at) as report_date, SUM(CASE WHEN nama = "visitors" THEN jumlah ELSE 0 END) as visitors_count, SUM(CASE WHEN nama = "views" THEN jumlah ELSE 0 END) as views_count')
                            ->groupBy('report_date')
                            ->orderBy('report_date', 'asc') // Order by date for chronological export
                            ->get();
        
        return $visitorData->map(function ($visitor) {
            return [
                Carbon::parse($visitor->report_date)->format('d M Y'),
                $visitor->visitors_count,
                $visitor->views_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pengunjung',
            'Dilihat',
        ];
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
