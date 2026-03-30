<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPpid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilPpidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profilPpids = ProfilPpid::all();
        return view('admin.profil-ppid.index', compact('profilPpids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profil-ppid.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'boolean',
            'vision' => 'nullable|string',
            'mission' => 'nullable|array',
            'mission.*' => 'nullable|string',
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'maps_url' => 'nullable|url|max:2048',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('structure_image')) {
            $validatedData['structure_image'] = $request->file('structure_image')->store('profil-ppid', 'public');
        }




        // Filter out empty mission strings
        if (isset($validatedData['mission'])) {
            $validatedData['mission'] = array_values(array_filter($validatedData['mission'], function($value) {
                return $value !== null && $value !== '';
            }));
        }

        // If the new profile is active, deactivate all other profiles
        if (isset($validatedData['status']) && $validatedData['status']) {
            ProfilPpid::where('status', true)->update(['status' => false]);
        }

        ProfilPpid::create($validatedData);

        return redirect()->route('admin.profil-ppid.index')->with('success', 'Profil PPID berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilPpid $profilPpid)
    {
        // Not used for now, will be implemented if a dedicated show page is needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilPpid $profilPpid)
    {
        return view('admin.profil-ppid.edit', compact('profilPpid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfilPpid $profilPpid)
    {
        $validatedData = $request->validate([
            'status' => 'boolean',
            'vision' => 'nullable|string',
            'mission' => 'nullable|array',
            'mission.*' => 'nullable|string',
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'maps_url' => 'nullable|url|max:2048',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        // Handle structure_image upload
        if ($request->hasFile('structure_image')) {
            if ($profilPpid->structure_image) {
                Storage::disk('public')->delete($profilPpid->structure_image);
            }
            $validatedData['structure_image'] = $request->file('structure_image')->store('profil-ppid', 'public');
        } else {
            // Retain existing image if no new upload and no clear instruction
            $validatedData['structure_image'] = $profilPpid->structure_image;
        }






        // Filter out empty mission strings
        if (isset($validatedData['mission'])) {
            $validatedData['mission'] = array_values(array_filter($validatedData['mission'], function($value) {
                return $value !== null && $value !== '';
            }));
        }

        // If the updated profile is active, deactivate all other profiles
        if (isset($validatedData['status']) && $validatedData['status']) {
            ProfilPpid::where('id', '!=', $profilPpid->id)->where('status', true)->update(['status' => false]);
        }
        
        $profilPpid->update($validatedData);

        return redirect()->route('admin.profil-ppid.index')->with('success', 'Profil PPID berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilPpid $profilPpid)
    {
        // Delete associated images
        if ($profilPpid->structure_image) {
            Storage::disk('public')->delete($profilPpid->structure_image);
        }


        $profilPpid->delete();

        return redirect()->route('admin.profil-ppid.index')->with('deleted', 'Profil PPID berhasil dihapus.');
    }}
