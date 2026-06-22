<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicSurveyController extends Controller
{
    public function show(Survey $survey)
    {
        $isActive = $survey->status === 'Aktif';

        if (!$isActive) {
            return view('public.surveys.inactive');
        }

        $survey->load(['questions.options', 'sections']);

        return view('public.surveys.show', compact('survey'));
    }

    public function store(Request $request, Survey $survey)
    {
        $rules = [];
        foreach ($survey->questions as $question) {
            if ($question->is_required) {
                $rules['answers.' . $question->id] = 'required';
            } else {
                $rules['answers.' . $question->id] = 'nullable';
            }
        }

        $validatedData = $request->validate($rules, [
            'answers.*.required' => 'Pertanyaan ini wajib diisi.',
        ]);

        $response = $survey->responses()->create([
            'respondent_ip' => $request->ip(),
        ]);

        $answers = $validatedData['answers'] ?? [];
        foreach ($answers as $questionId => $answer) {
            if (is_null($answer)) continue;

            $answerText = is_array($answer) ? json_encode($answer) : $answer;
            
            $response->answers()->create([
                'question_id' => $questionId,
                'answer_text' => $answerText,
            ]);
        }

        return redirect()->route('public.surveys.thankyou');
    }

    public function thankyou()
    {
        return view('public.surveys.thankyou');
    }
}
