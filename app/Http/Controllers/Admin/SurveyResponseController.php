<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
{
    private function getSortedQuestions(Survey $survey)
    {
        return $survey->questions->load('section')->sort(function($a, $b) {
            $sectionOrderA = $a->section ? $a->section->order : -1;
            $sectionOrderB = $b->section ? $b->section->order : -1;

            if ($sectionOrderA === $sectionOrderB) {
                return $a->order <=> $b->order;
            }
            return $sectionOrderA <=> $sectionOrderB;
        });
    }

    public function index(Survey $survey)
    {
        $survey->load(['questions.options', 'responses.answers']);
        $sortedQuestions = $this->getSortedQuestions($survey);

        $chartData = [];

        foreach ($sortedQuestions as $question) {
            if (in_array($question->question_type, ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)', 'Checkbox', 'Dropdown', 'Skala Kepuasan'])) {
                
                $data = [];
                $labels = [];

                if ($question->question_type === 'Skala Kepuasan') {
                    // For Scale, usually 1-5
                    for ($i = 1; $i <= 5; $i++) {
                        $labels[$i] = (string)$i;
                        $data[$i] = 0;
                    }
                } else {
                    // For options based questions
                    foreach ($question->options as $option) {
                        $label = $option->option_text;
                        if ($question->question_type === 'Pilihan Ganda (Berbobot)' && !is_null($option->value)) {
                            $label = $option->value . ' (' . $option->option_text . ')';
                        }
                        $labels[$option->id] = $label;
                        $data[$option->id] = 0;
                    }
                }

                foreach ($survey->responses as $response) {
                    $answer = $response->answers->firstWhere('question_id', $question->id);
                    if ($answer) {
                        if ($question->question_type === 'Skala Kepuasan') {
                            $val = $answer->answer_text;
                            if (isset($data[$val])) {
                                $data[$val]++;
                            }
                        } elseif (in_array($question->question_type, ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)', 'Dropdown'])) {
                            // Single ID stored
                            $optionId = $answer->answer_text;
                            if (isset($data[$optionId])) {
                                $data[$optionId]++;
                            }
                        } elseif ($question->question_type === 'Checkbox') {
                            // Array of IDs
                            $optionIds = json_decode($answer->answer_text, true) ?: [];
                            if (!is_array($optionIds)) $optionIds = [$answer->answer_text];
                            
                            foreach ($optionIds as $optId) {
                                if (isset($data[$optId])) {
                                    $data[$optId]++;
                                }
                            }
                        }
                    }
                }

                $chartData[$question->id] = [
                    'labels' => array_values($labels),
                    'data' => array_values($data),
                    'type' => 'bar', // Default to bar
                ];
            }
        }

        return view('admin.responses.index', compact('survey', 'chartData', 'sortedQuestions'));
    }

    public function export(Survey $survey)
    {
        $survey->load(['questions.options', 'responses.answers']);
        $sortedQuestions = $this->getSortedQuestions($survey);
        
        $fileName = 'survey_responses_' . $survey->id . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($survey, $sortedQuestions) {
            $file = fopen('php://output', 'w');

            // Header Row
            $columns = ['Responden #', 'Tanggal Submit'];
            foreach ($sortedQuestions as $question) {
                $columns[] = \Illuminate\Support\Str::limit($question->question_text, 50);
            }
            fputcsv($file, $columns);

            // Data Rows
            foreach ($survey->responses as $index => $response) {
                $row = [
                    $index + 1,
                    $response->created_at->format('d M Y, H:i')
                ];

                foreach ($sortedQuestions as $question) {
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

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request, Survey $survey)
    {
        $survey->load(['questions.options', 'responses.answers']);
        $sortedQuestions = $this->getSortedQuestions($survey);
        
        $chartImages = $request->input('chart_images', []);

        $fileName = 'survey_report_' . $survey->id . '_' . date('Ymd_His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SingleSurveyExport($survey, $sortedQuestions, $chartImages), 
            $fileName
        );
    }

    public function updateAnswer(Request $request, Survey $survey)
    {
        $request->validate([
            'response_id' => 'required|exists:survey_responses,id',
            'question_id' => 'required|exists:survey_questions,id',
            'answer_text' => 'required',
        ]);

        $response = SurveyResponse::findOrFail($request->response_id);
        
        $answer = $response->answers()->firstOrNew(['question_id' => $request->question_id]);
        
        $question = \App\Models\SurveyQuestion::findOrFail($request->question_id);
        if ($question->question_type === 'Checkbox') {
            // For checkbox, it expects a JSON array of option IDs
            $answer->answer_text = json_encode([$request->answer_text]);
        } else {
            $answer->answer_text = $request->answer_text;
        }
        
        $answer->save();

        return back()->with('success', 'Jawaban responden berhasil diperbarui secara manual.');
    }

    public function edit(Survey $survey, SurveyResponse $response)
    {
        $survey->load(['questions.options', 'responses.answers']);
        $sortedQuestions = $this->getSortedQuestions($survey);
        
        return view('admin.responses.edit', compact('survey', 'response', 'sortedQuestions'));
    }

    public function updateAll(Request $request, Survey $survey, SurveyResponse $response)
    {
        $answersData = $request->input('answers', []);
        if (!is_array($answersData)) {
            $answersData = [];
        }
        
        $applyToAllQuestions = $request->input('apply_to_all_questions', []);
        
        $questions = \App\Models\SurveyQuestion::whereIn('id', array_keys($answersData))->get()->keyBy('id');
        $allResponses = $survey->responses;

        $hasAnyBulkUpdate = false;

        foreach ($answersData as $questionId => $answerText) {
            $question = $questions->get($questionId);
            if (!$question) continue;
            
            $applyToAll = !empty($applyToAllQuestions[$questionId]);
            if ($applyToAll) $hasAnyBulkUpdate = true;
            
            $targetResponses = $applyToAll ? $allResponses : collect([$response]);

            foreach ($targetResponses as $targetResponse) {
                $answer = $targetResponse->answers()->firstOrNew(['question_id' => $questionId]);
                
                // Prevent null constraint violations due to Laravel's ConvertEmptyStringsToNull middleware
                // Prevent Array to String conversion errors
                if ($question->question_type === 'Checkbox' || is_array($answerText)) {
                    $val = is_array($answerText) ? $answerText : [$answerText];
                    // If it was null, make it an empty array so it encodes to "[]" instead of "[null]"
                    if ($answerText === null) {
                        $val = [];
                    }
                    $answer->answer_text = json_encode($val);
                } else {
                    $answer->answer_text = (string) $answerText;
                }
                
                $answer->save();
            }
        }

        $message = $hasAnyBulkUpdate 
            ? 'Beberapa jawaban berhasil diseragamkan ke seluruh responden.' 
            : 'Jawaban responden berhasil diperbarui.';

        return redirect()->route('admin.surveys.responses.index', $survey->slug)
                         ->with('success', $message);
    }
}
