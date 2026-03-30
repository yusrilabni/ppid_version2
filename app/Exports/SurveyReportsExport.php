<?php

namespace App\Exports;

use App\Models\SurveyResponse;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; // Add this line
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Add this line
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection; // Add this line

class SurveyReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles // Add WithStyles here
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
        return SurveyResponse::when($this->startDate, function ($query) {
                                return $query->where('created_at', '>=', $this->startDate);
                            })
                            ->when($this->endDate, function ($query) {
                                return $query->where('created_at', '<=', $this->endDate->endOfDay());
                            })
                            ->whereHas('survey', function ($query) {
                                $query->where('status', 'active');
                            })
                            ->with(['survey', 'user', 'answers']) // Eager load user and answers
                            ->latest()
                            ->get()
                            ->map(function ($surveyResponse) {
                                $respondenDisplay = '';
                                if ($surveyResponse->privacy_status === 'anonim') {
                                    $respondenDisplay = 'Anonim';
                                } elseif ($surveyResponse->privacy_status === 'publik') {
                                    $respondenDisplay = $surveyResponse->responden_name ?? ($surveyResponse->user->name ?? 'N/A');
                                } else { // rahasia
                                    $respondenDisplay = '****';
                                }

                                $answersSummary = $surveyResponse->answers->map(function ($answer) {
                                    return $answer->answer_text;
                                })->implode('; ');

                                return [
                                    $surveyResponse->id,
                                    $surveyResponse->survey->title ?? 'N/A',
                                    $respondenDisplay,
                                    $surveyResponse->created_at->format('d M Y H:i:s'),
                                    $answersSummary, // Concatenated answers
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
            'Detail Jawaban', // New heading
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
