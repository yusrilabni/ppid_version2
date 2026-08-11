<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SurveyApiController extends Controller
{
    public function show(Survey $survey)
    {
        $isActive = $survey->status === 'Aktif';

        if (!$isActive) {
            return response()->json([
                'success' => false,
                'message' => 'Survei ini tidak aktif.'
            ], 404);
        }

        $survey->load(['questions.options', 'sections']);

        return response()->json([
            'success' => true,
            'data' => $survey
        ]);
    }

    public function submit(Request $request, Survey $survey)
    {
        if ($survey->status !== 'Aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Survei ini tidak aktif.'
            ], 400);
        }

        // Limit IP to prevent spamming within 24 hours
        // DINONAKTIFKAN SEMENTARA agar admin/penguji bisa melakukan tes berulang kali
        /*
        $ipExists = SurveyResponse::where('survey_id', $survey->id)
            ->where('respondent_ip', $request->ip())
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();
            
        if ($ipExists) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengisi survei ini dalam 24 jam terakhir.'
            ], 429);
        }
        */

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

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas partisipasi Anda!'
        ]);
    }
}
