<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicSurveyController extends Controller
{
    public function show(Request $request, Survey $survey)
    {
        $isActive = $survey->status === 'Aktif';

        if (!$isActive) {
            return view('public.surveys.inactive');
        }

        $cookieName = 'survey_submitted_' . $survey->id;
        if ($request->session()->has($cookieName) || $request->hasCookie($cookieName)) {
            return redirect()->route('public.surveys.thankyou')->with('message', 'Anda sudah mengisi kuesioner ini sebelumnya.');
        }

        // Limit IP to prevent spamming within 24 hours
        $ipExists = SurveyResponse::where('survey_id', $survey->id)
            ->where('respondent_ip', $request->ip())
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();
        if ($ipExists) {
            return redirect()->route('public.surveys.thankyou')->with('message', 'Anda sudah mengisi kuesioner ini sebelumnya dari jaringan ini.');
        }

        $survey->load(['questions.options', 'sections']);

        return view('public.surveys.show', compact('survey'));
    }

    public function store(Request $request, Survey $survey)
    {
        $cookieName = 'survey_submitted_' . $survey->id;
        if ($request->session()->has($cookieName) || $request->hasCookie($cookieName)) {
            return redirect()->route('public.surveys.thankyou')->with('message', 'Anda sudah mengisi kuesioner ini sebelumnya.');
        }

        $ipExists = SurveyResponse::where('survey_id', $survey->id)
            ->where('respondent_ip', $request->ip())
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();
        if ($ipExists) {
            return redirect()->route('public.surveys.thankyou')->with('message', 'Anda sudah mengisi kuesioner ini sebelumnya dari jaringan ini.');
        }

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

        // Set session and long-lived cookie (1 year) to prevent spam
        $request->session()->put($cookieName, '1');
        $cookie = cookie($cookieName, '1', 60 * 24 * 365);

        return redirect()->route('public.surveys.thankyou')
            ->with('message', 'Terima kasih atas partisipasi Anda!')
            ->withCookie($cookie);
    }

    public function thankyou()
    {
        return view('public.surveys.thankyou');
    }
}
