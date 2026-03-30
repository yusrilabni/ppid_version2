<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PbjQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PbjQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $questionsByYear = PbjQuestion::whereNull('parent_id')
            ->with('children')
            ->orderBy('year', 'desc')
            ->orderBy('order')
            ->get()
            ->groupBy('year');

        return view('admin.pbj.questions.index', compact('questionsByYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $all_categories = PbjQuestion::where('is_category', true)->orderBy('order')->orderBy('question')->get();
        
        $categories = [];
        
        $buildTree = function ($items, $parentId = null, $prefix = '') use (&$categories, &$buildTree) {
            $filtered = $items->where('parent_id', $parentId);
            
            foreach ($filtered as $item) {
                // Apply a longer limit to fit the content area better
                $truncatedQuestion = \Illuminate\Support\Str::limit($item->question, 100);
                $categories[] = (object)[
                    'id' => $item->id,
                    'question' => $prefix . $truncatedQuestion,
                    'full_question' => $item->question,
                    'year' => $item->year,
                ];
                $buildTree($items, $item->id, $prefix . '&nbsp;&nbsp;&nbsp;&nbsp;');
            }
        };
        
        $buildTree($all_categories);

        $all_questions = PbjQuestion::all();

        return view('admin.pbj.questions.create', compact('categories', 'year', 'all_questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info($request->all());

        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string|max:1000',
            'questions.*.order' => 'required|integer',
            'questions.*.submission_type' => 'required|string|in:none,link,file',
            'parent_id' => 'nullable|exists:pbj_questions,id',
            'is_category' => 'nullable|boolean',
            'year' => 'required|integer|min:2000',
        ]);

        $commonData = $request->only('parent_id', 'year') + [
            'is_category' => $request->has('is_category'),
        ];

        foreach ($request->questions as $questionData) {
            $submission_type = $questionData['submission_type'];

            PbjQuestion::create($commonData + [
                'question' => $questionData['question'],
                'order' => $questionData['order'],
                'requires_link_submission' => $submission_type === 'link',
                'requires_file_submission' => $submission_type === 'file',
            ]);
        }

        return redirect()->route('admin.pbj-questions.index', ['year' => $request->year])->with('success', count($request->questions) . ' pertanyaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PbjQuestion $pbj_question)
    {
        // Not used for now
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PbjQuestion $pbj_question)
    {
        $all_categories = PbjQuestion::where('is_category', true)
            ->where('id', '!=', $pbj_question->id)
            ->orderBy('order')
            ->orderBy('question')
            ->get();
            
        $categories = [];
        
        $buildTree = function ($items, $parentId = null, $prefix = '') use (&$categories, &$buildTree) {
            $filtered = $items->where('parent_id', $parentId);
            
            foreach ($filtered as $item) {
                // Apply a longer limit to fit the content area better
                $truncatedQuestion = \Illuminate\Support\Str::limit($item->question, 100);
                $categories[] = (object)[
                    'id' => $item->id,
                    'question' => $prefix . $truncatedQuestion,
                    'full_question' => $item->question,
                    'year' => $item->year,
                ];
                $buildTree($items, $item->id, $prefix . '&nbsp;&nbsp;&nbsp;&nbsp;');
            }
        };
        
        $buildTree($all_categories);
            
        return view('admin.pbj.questions.edit', compact('pbj_question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PbjQuestion $pbj_question)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:pbj_questions,id',
            'is_category' => 'nullable|boolean',
            'order' => 'required|integer',
            'year' => 'required|integer|min:2000',
            'submission_type' => 'required|string|in:none,link,file',
        ]);

        $submission_type = $request->submission_type;

        $updateData = $request->only('question', 'parent_id', 'order', 'year') + [
            'is_category' => $request->has('is_category'),
            'requires_link_submission' => $submission_type === 'link',
            'requires_file_submission' => $submission_type === 'file',
        ];
        
        $pbj_question->update($updateData);

        return redirect()->route('admin.pbj-questions.index', ['year' => $request->year])->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PbjQuestion $pbj_question)
    {
        // Also deletes child questions due to cascade on delete in migration
        // No files to delete as they are not directly attached to the question anymore
        $pbj_question->delete();
        return redirect()->route('admin.pbj-questions.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Delete all questions for a specific year.
     */
    public function deleteYear(int $year)
    {
        Log::info("Attempting to delete all questions for year: {$year}.");
        $deletedCount = PbjQuestion::where('year', $year)->delete();
        Log::info("Deleted {$deletedCount} questions for year {$year}.");

        return redirect()->route('admin.pbj-questions.index')->with('success', "Semua pertanyaan untuk tahun {$year} berhasil dihapus.");
    }

    /**
     * Duplicate questions from a source year to a destination year.
     */
    public function duplicate(Request $request)
    {
        Log::info('Starting duplication process.');
        Log::info('Source year: ' . $request->source_year);
        Log::info('Destination year: ' . $request->destination_year);

        $request->validate([
            'source_year' => 'required|integer|exists:pbj_questions,year',
            'destination_year' => 'required|integer|min:2000|different:source_year',
        ]);

        Log::info('Validation passed.');

        $sourceYear = $request->source_year;
        $destYear = $request->destination_year;

        // Delete existing questions for the destination year
        $deletedRows = PbjQuestion::where('year', $destYear)->delete();
        Log::info("Deleted {$deletedRows} rows from destination year {$destYear}.");

        $sourceQuestions = PbjQuestion::where('year', $sourceYear)
            ->whereNull('parent_id')
            ->with('children') // Eager load children for recursion
            ->orderBy('order')
            ->get();
        
        $count = $sourceQuestions->count();
        Log::info("Found {$count} top-level questions to duplicate.");

        $oldIdToNewIdMap = [];

        foreach ($sourceQuestions as $question) {
            $this->recursivelyDuplicateQuestion($question, null, $destYear, $oldIdToNewIdMap);
        }
        
        Log::info('Duplication process finished.');

        $message = "Proses duplikasi dari tahun {$sourceYear} ke {$destYear} selesai. {$count} pertanyaan utama disalin.";
        return redirect()->route('admin.pbj-questions.index')->with('success', $message);
    }

    /**
     * Recursively duplicates a question and its children.
     */
    private function recursivelyDuplicateQuestion(PbjQuestion $question, ?int $newParentId, int $destinationYear, array &$oldIdToNewIdMap)
    {
        Log::info("Replicating question ID: {$question->id} ('{$question->question}')");

        $newQuestion = $question->replicate();
        $newQuestion->year = $destinationYear;
        $newQuestion->parent_id = $newParentId;
        $newQuestion->save();
        
        Log::info("Saved new question with ID: {$newQuestion->id}");

        $oldIdToNewIdMap[$question->id] = $newQuestion->id;

        Log::info("Question has {$question->children->count()} children.");
        foreach ($question->children as $child) {
            $this->recursivelyDuplicateQuestion($child, $newQuestion->id, $destinationYear, $oldIdToNewIdMap);
        }
    }
}
