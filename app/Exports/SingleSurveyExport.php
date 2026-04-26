<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Str;

class SingleSurveyExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithDrawings, ShouldAutoSize
{
    protected $survey;
    protected $sortedQuestions;
    protected $chartImages;

    public function __construct($survey, $sortedQuestions, $chartImages = [])
    {
        $this->survey = $survey;
        $this->sortedQuestions = $sortedQuestions;
        $this->chartImages = $chartImages;
    }

    public function collection()
    {
        $rows = [];
        foreach ($this->survey->responses as $index => $response) {
            $row = [
                $index + 1,
                $response->created_at->format('d M Y, H:i')
            ];

            foreach ($this->sortedQuestions as $question) {
                $answer = $response->answers->firstWhere('question_id', $question->id);
                $answerText = '-';

                if ($answer) {
                    if (in_array($question->question_type, ['Checkbox', 'Pilihan Ganda', 'Dropdown', 'Pilihan Ganda (Berbobot)'])) {
                        $optionIds = json_decode($answer->answer_text, true) ?: [$answer->answer_text];
                        $selectedOptions = $question->options->whereIn('id', $optionIds);
                        
                        $formattedOptions = $selectedOptions->map(function($option) use ($question) {
                            if ($question->question_type === 'Pilihan Ganda (Berbobot)' && !is_null($option->value)) {
                                return $option->value;
                            }
                            return $option->option_text;
                        });
                        
                        $answerText = $formattedOptions->implode(', ') ?: $answer->answer_text;
                    } else {
                        $answerText = $answer->answer_text;
                    }
                }
                $row[] = $answerText;
            }
            $rows[] = $row;
        }

        return collect($rows);
    }

    public function headings(): array
    {
        $headings = ['No.', 'Waktu Submit'];
        foreach ($this->sortedQuestions as $question) {
            $headings[] = $question->question_text;
        }
        return $headings;
    }

    public function title(): string
    {
        return 'Data Respon';
    }

    public function drawings()
    {
        $drawings = [];
        $currentRow = count($this->survey->responses) + 5; // Start images after the data table

        foreach ($this->chartImages as $index => $base64Image) {
            if (empty($base64Image)) continue;

            // Remove headers: data:image/png;base64, or data:image/jpeg;base64,
            $image = preg_replace('#^data:image/[^;]+;base64,#', '', $base64Image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'chart_' . time() . '_' . $index . '.png';
            $path = storage_path('app/public/temp/' . $imageName);
            
            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }
            
            file_put_contents($path, base64_decode($image));

            $drawing = new Drawing();
            $drawing->setName('Chart ' . ($index + 1));
            $drawing->setDescription('Grafik Respon');
            $drawing->setPath($path);
            $drawing->setHeight(300); // 300px height
            $drawing->setCoordinates('B' . ($currentRow + ($index * 20))); // Stack images vertically
            
            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
