<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PbjQuestion;
use App\Models\PbjAnswer;
use Illuminate\Http\Request;

class PbjController extends Controller
{
    public function getYears()
    {
        $years = PbjQuestion::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        return response()->json(['success' => true, 'data' => $years]);
    }

    public function getQuestions(Request $request)
    {
        $year = $request->get('year');
        
        if (!$year) {
            $year = PbjQuestion::max('year') ?? date('Y');
        }

        $questions = PbjQuestion::where('year', $year)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        $answers = PbjAnswer::with('informasi')
            ->where('year', $year)
            ->get()
            ->keyBy('pbj_question_id');

        // Format data
        $formattedQuestions = $questions->map(function ($q) use ($answers) {
            return $this->formatQuestion($q, $answers);
        });

        return response()->json([
            'success' => true,
            'data' => [
                'year' => $year,
                'questions' => $formattedQuestions
            ]
        ]);
    }

    private function formatQuestion($question, $answers)
    {
        $ans = $answers->get($question->id);
        
        $informasi = null;
        if ($ans && $ans->informasi) {
            $informasi = [
                'id' => $ans->informasi->id,
                'title' => $ans->informasi->title,
                'url' => $ans->informasi->url,
                'file_url' => $ans->informasi->file_url,
                'slug' => $ans->informasi->slug,
            ];
        }

        return [
            'id' => $question->id,
            'question' => $question->question,
            'order' => $question->order,
            'answer' => $ans ? [
                'id' => $ans->id,
                'document_url' => $ans->document_url,
                'informasi' => $informasi
            ] : null,
            'children' => $question->children->map(function ($child) use ($answers) {
                return $this->formatQuestion($child, $answers);
            })->sortBy('order')->values()
        ];
    }
}
