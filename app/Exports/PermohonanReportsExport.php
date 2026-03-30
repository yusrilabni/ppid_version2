<?php

namespace App\Exports;

use App\Models\PermohonanInformasi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection; // Add this line

class PermohonanReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles // Add WithStyles here
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
        return PermohonanInformasi::when($this->startDate, function ($query) {
                                return $query->where('created_at', '>=', $this->startDate);
                            })
                            ->when($this->endDate, function ($query) {
                                return $query->where('created_at', '<=', $this->endDate->endOfDay());
                            })
                            ->with('user') // Eager load the user relationship
                            ->latest()
                            ->get()
                            ->map(function ($permohonan) {
                                $pemohon = '';
                                if ($permohonan->privacy_status === 'anonim') {
                                    $pemohon = 'Anonim';
                                } elseif ($permohonan->privacy_status === 'publik') {
                                    $pemohon = $permohonan->user->name ?? 'N/A';
                                } else { // rahasia
                                    $pemohon = '****';
                                }

                                return [
                                    $permohonan->unique_code,
                                    $permohonan->subject,
                                    $permohonan->description, // Added description
                                    $pemohon, // Pemohon with privacy logic
                                    $permohonan->created_at->format('d M Y H:i:s'),
                                    $permohonan->status,
                                ];
                            });
    }

    public function headings(): array
    {
        return [
            'Kode Unik',
            'Subjek Permohonan',
            'Deskripsi Permohonan',
            'Pemohon',
            'Tanggal Permohonan',
            'Status',
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
