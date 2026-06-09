<?php

namespace App\Exports;

use App\Models\Informasi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection; // Add this line

class InformasiReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles // Add WithStyles here
{
    protected $startDate;
    protected $endDate;

    public function __construct(string $startDate = null, string $endDate = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate) : null;
        $this->endDate = $endDate ? Carbon::parse($endDate) : null;
    }

    public function collection()
    {
        return Informasi::when($this->startDate, function ($query) {
                                return $query->where('tanggal_upload', '>=', $this->startDate);
                            })
                            ->when($this->endDate, function ($query) {
                                return $query->where('tanggal_upload', '<=', $this->endDate->endOfDay());
                            })
                            ->with('organization') // Eager load organization
                            ->latest()
                            ->get()
                            ->map(function ($informasi) {
                                return [
                                    $informasi->title,
                                    $informasi->category,
                                    $informasi->jenis_dokumen, // Added jenis_dokumen
                                    $informasi->status,
                                    $informasi->organization->name ?? 'N/A', // Added organization name
                                    $informasi->tanggal_upload ? Carbon::parse($informasi->tanggal_upload)->format('d M Y') : $informasi->created_at->format('d M Y'),
                                    $informasi->download_count,
                                    \route('frontend.informasi.detail', ['slug' => $informasi->slug]), // Generate detail URL
                                ];
                            });
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Kategori',
            'Jenis Dokumen',
            'Status',
            'Unit',
            'Tanggal Upload',
            'Jumlah Download',
            'URL Detail', // Updated heading
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
