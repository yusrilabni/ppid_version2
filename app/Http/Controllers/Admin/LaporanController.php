<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Filter only 'tahunan' type for this view as requested
        $laporans = Laporan::where('type', 'tahunan')->latest()->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'content' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'required|mimes:pdf|max:10240', // Max 10MB PDF
            'published' => 'nullable|boolean',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('laporan/covers', 'public');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('laporan/files', 'public');
        }

        Laporan::create([
            'title' => $validatedData['title'],
            'tahun' => $validatedData['tahun'],
            'content' => $validatedData['content'],
            'type' => 'tahunan',
            'cover' => $coverPath,
            'file' => $filePath,
            'published' => $request->has('published'),
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diupload.');
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
    public function edit(Laporan $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'content' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|mimes:pdf|max:10240',
            'published' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $validatedData['title'],
            'tahun' => $validatedData['tahun'],
            'content' => $validatedData['content'],
            'published' => $request->has('published'),
        ];

        if ($request->hasFile('cover')) {
            // Delete old cover
            if ($laporan->cover) {
                Storage::disk('public')->delete($laporan->cover);
            }
            $updateData['cover'] = $request->file('cover')->store('laporan/covers', 'public');
        }

        if ($request->hasFile('file')) {
            // Delete old file
            if ($laporan->file) {
                Storage::disk('public')->delete($laporan->file);
            }
            $updateData['file'] = $request->file('file')->store('laporan/files', 'public');
        }

        $laporan->update($updateData);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->cover) {
            Storage::disk('public')->delete($laporan->cover);
        }
        if ($laporan->file) {
            Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}