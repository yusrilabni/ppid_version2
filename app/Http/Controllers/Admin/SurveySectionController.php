<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveySection;
use Illuminate\Http\Request;

class SurveySectionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Survey $survey)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $section = $survey->sections()->create($validatedData);

        return redirect()->route('admin.surveys.show', $survey)->with('success', 'Bagian berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SurveySection $section)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $section->update($validatedData);

        return redirect()->route('admin.surveys.show', $section->survey)->with('success', 'Bagian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveySection $section)
    {
        $survey = $section->survey;
        // Opsional: Pindahkan pertanyaan ke section lain atau null-kan section_id mereka sebelum hapus, 
        // tapi di migration sudah set nullOnDelete, jadi aman.
        
        $section->delete();

        return redirect()->route('admin.surveys.show', $survey)->with('success', 'Bagian berhasil dihapus.');
    }
}
