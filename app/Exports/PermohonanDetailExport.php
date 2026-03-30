<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use App\Models\PermohonanInformasi;
use Carbon\Carbon;

class PermohonanDetailExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithStyles // Add WithStyles here
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
        return PermohonanInformasi::when($this->startDate, function ($query) {
                                return $query->where('created_at', '>=', $this->startDate);
                            })
                            ->when($this->endDate, function ($query) {
                                return $query->where('created_at', '<=', $this->endDate->endOfDay());
                            })
                            ->with('user') // Eager load user for applicant name
                            ->get()
                            ->map(function ($permohonan) {
                                $applicantName = '';
                                if ($permohonan->privacy_status === 'anonim') {
                                    $applicantName = 'Anonim';
                                } elseif ($permohonan->privacy_status === 'publik') {
                                    $applicantName = $permohonan->user->name ?? 'N/A';
                                } else { // rahasia
                                    $applicantName = '****';
                                }

                                return [
                                    $permohonan->unique_code,
                                    $permohonan->subject,
                                    $applicantName,
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
            'Pemohon',
            'Tanggal Permohonan',
            'Status',
        ];
    }

    public function title(): string
    {
        return 'Permohonan Detail';
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
