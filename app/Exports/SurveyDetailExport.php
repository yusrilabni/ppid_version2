<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use App\Models\SurveyResponse;
use Carbon\Carbon;

class SurveyDetailExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithStyles // Add WithStyles here
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
        return SurveyResponse::when($this->startDate, function ($query) {
                                return $query->where('created_at', '>=', $this->startDate);
                            })
                            ->when($this->endDate, function ($query) {
                                return $query->where('created_at', '<=', $this->endDate->endOfDay());
                            })
                            ->whereHas('survey', function ($query) { // Filter by active survey
                                $query->where('status', 'active');
                            })
                            ->with(['survey', 'user']) // Eager load survey and user
                            ->get()
                            ->map(function ($surveyResponse) {
                                $respondentName = '';
                                if ($surveyResponse->privacy_status === 'anonim') {
                                    $respondentName = 'Anonim';
                                } elseif ($surveyResponse->privacy_status === 'publik') {
                                    $respondentName = $surveyResponse->responden_name ?? ($surveyResponse->user->name ?? 'N/A');
                                } else { // rahasia
                                    $respondentName = '****';
                                }

                                return [
                                    $surveyResponse->id,
                                    $surveyResponse->survey->title ?? 'N/A',
                                    $respondentName,
                                    $surveyResponse->created_at->format('d M Y H:i:s'),
                                ];
                            });
    }

    public function headings(): array
    {
        return [
            'ID Respon',
            'Nama Survei',
            'Responden',
            'Tanggal Pengisian',
        ];
    }

    public function title(): string
    {
        return 'Survei Detail';
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
