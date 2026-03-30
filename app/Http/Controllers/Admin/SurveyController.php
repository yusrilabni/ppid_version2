<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveys = Survey::latest()->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Draft,Aktif,Nonaktif',
            'type' => 'required|string|in:default,publik,private,skm,ppid',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validatedData['type'] === 'default') {
            Survey::where('type', 'default')->update(['type' => 'publik']);
        }

        $survey = Survey::create($validatedData + ['created_by' => auth()->id()]);

        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        $survey->load('questions');
        return view('admin.surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        return view('admin.surveys.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Draft,Aktif,Nonaktif',
            'type' => 'required|string|in:default,publik,private,skm,ppid',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validatedData['type'] === 'default') {
            Survey::where('type', 'default')->where('id', '!=', $survey->id)->update(['type' => 'publik']);
        }

        $survey->update($validatedData);

        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil dihapus.');
    }

    public function reports()
    {
        $surveys = Survey::withCount('responses')->get();
        return view('admin.surveys.reports', compact('surveys'));
    }
}
