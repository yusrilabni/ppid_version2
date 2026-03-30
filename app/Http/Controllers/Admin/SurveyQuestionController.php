<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Survey $survey)
    {
        return view('admin.questions.create', compact('survey'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Survey $survey)
    {
        $messages = [
            'question_text.required' => 'Teks pertanyaan wajib diisi.',
            'question_type.required' => 'Jenis pertanyaan wajib dipilih.',
            'options.required_if' => 'Pertanyaan jenis ini wajib memiliki minimal satu opsi jawaban.',
            'options.*.text.required_with' => 'Teks opsi jawaban tidak boleh kosong.',
            'options.*.text.max' => 'Teks opsi terlalu panjang (maksimal 255 karakter).',
            'options.*.value.integer' => 'Nilai bobot harus berupa angka.',
        ];

        $validatedData = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:Isian Singkat,Isian Panjang,Pilihan Ganda,Pilihan Ganda (Berbobot),Checkbox,Dropdown,Skala Kepuasan,Email,Numeric,Url',
            'is_required' => 'nullable|boolean',
            'section_id' => 'nullable|exists:survey_sections,id',
            'options' => [
                'exclude_unless:question_type,Pilihan Ganda,Pilihan Ganda (Berbobot),Checkbox,Dropdown',
                'required_if:question_type,Pilihan Ganda,Pilihan Ganda (Berbobot),Checkbox,Dropdown',
                'array',
            ],
            'options.*.text' => 'required_with:options|string|max:255',
            'options.*.value' => 'nullable|integer',
        ], $messages);

        $question = $survey->questions()->create([
            'question_text' => $validatedData['question_text'],
            'question_type' => $validatedData['question_type'],
            'is_required' => $request->has('is_required'),
            'section_id' => $validatedData['section_id'] ?? null,
        ]);

        if (in_array($validatedData['question_type'], ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)', 'Checkbox', 'Dropdown']) && isset($validatedData['options'])) {
            foreach ($validatedData['options'] as $optionData) {
                if (is_array($optionData) && !empty($optionData['text'])) {
                    $value = ($validatedData['question_type'] === 'Pilihan Ganda (Berbobot)') ? ($optionData['value'] ?? null) : null;
                    
                    $question->options()->create([
                        'option_text' => $optionData['text'],
                        'value' => $value,
                    ]);
                } elseif (is_string($optionData) && !empty($optionData)) {
                    $question->options()->create(['option_text' => $optionData]);
                }
            }
        }

        return redirect()->route('admin.surveys.show', $survey)->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SurveyQuestion $question)
    {
        $question->load('options');
        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SurveyQuestion $question)
    {
        $messages = [
            'question_text.required' => 'Teks pertanyaan wajib diisi.',
            'question_type.required' => 'Jenis pertanyaan wajib dipilih.',
            'options.required_if' => 'Pertanyaan jenis ini wajib memiliki minimal satu opsi jawaban.',
            'options.*.text.required_with' => 'Teks opsi jawaban tidak boleh kosong.',
            'options.*.text.max' => 'Teks opsi terlalu panjang (maksimal 255 karakter).',
            'options.*.value.integer' => 'Nilai bobot harus berupa angka.',
        ];

        $validatedData = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:Isian Singkat,Isian Panjang,Pilihan Ganda,Pilihan Ganda (Berbobot),Checkbox,Dropdown,Skala Kepuasan,Email,Numeric,Url',
            'is_required' => 'nullable|boolean',
            'section_id' => 'nullable|exists:survey_sections,id',
            'options' => [
                'exclude_unless:question_type,Pilihan Ganda,Pilihan Ganda (Berbobot),Checkbox,Dropdown',
                'required_if:question_type,Pilihan Ganda,Pilihan Ganda (Berbobot),Checkbox,Dropdown',
                'array',
            ],
            'options.*.text' => 'required_with:options|string|max:255',
            'options.*.value' => 'nullable|integer',
        ], $messages);

        $question->update([
            'question_text' => $validatedData['question_text'],
            'question_type' => $validatedData['question_type'],
            'is_required' => $request->has('is_required'),
            'section_id' => $validatedData['section_id'] ?? null,
        ]);

        // Delete old options and create new ones
        $question->options()->delete();

        if (in_array($validatedData['question_type'], ['Pilihan Ganda', 'Pilihan Ganda (Berbobot)', 'Checkbox', 'Dropdown']) && isset($validatedData['options'])) {
            foreach ($validatedData['options'] as $optionData) {
                if (is_array($optionData) && !empty($optionData['text'])) {
                    $value = ($validatedData['question_type'] === 'Pilihan Ganda (Berbobot)') ? ($optionData['value'] ?? null) : null;
                    
                    $question->options()->create([
                        'option_text' => $optionData['text'],
                        'value' => $value,
                    ]);
                } elseif (is_string($optionData) && !empty($optionData)) {
                    $question->options()->create(['option_text' => $optionData]);
                }
            }
        }

        return redirect()->route('admin.surveys.show', $question->survey)->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveyQuestion $question)
    {
        $survey = $question->survey;
        $question->delete();

        return redirect()->route('admin.surveys.show', $survey)->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
