<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = Organization::all();
        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = [];
        $villagesGrouped = [];

        try {
            // Fetch General Units (OPD)
            $unitResponse = Http::get('http://apps.sinjaikab.go.id/api/pegawai/get_unit');
            if ($unitResponse->successful()) {
                $units = $unitResponse->json();
            }

            // Fetch Villages and group by Kecamatan
            $villageResponse = Http::get('http://apps.sinjaikab.go.id/api/pegawai/get_wilayah?tipe=Desa');
            if ($villageResponse->successful()) {
                $villages = collect($villageResponse->json());
                $villagesGrouped = $villages->groupBy('kecamatan_nama')->toArray();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching API data for organizations: ' . $e->getMessage());
        }

        return view('admin.organizations.create', compact('units', 'villagesGrouped'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|string|unique:organizations,unit_id',
        ]);

        // Generate unique slug from name
        $baseSlug = strtolower(str_replace(' ', '-', $request->name));
        $slug = $baseSlug;
        $counter = 1;

        // Check if slug already exists and make it unique
        while (Organization::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $organization = Organization::create([
            'unit_id' => $request->unit_id,
            'name' => $request->name,
            'slug' => $slug,
            'type' => 'opd', // Default to 'opd' as per specification
            'status' => 'active', // Default to 'active' as per specification
        ]);

        return redirect()->route('admin.organizations.index')->with('success', 'OPD berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        $positions = $organization->positions()->with(['parent', 'children', 'members.user'])->get();
        return view('admin.organizations.show', compact('organization', 'positions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:opd,kecamatan,unit',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate unique slug from name if it's changing
        $baseSlug = strtolower(str_replace(' ', '-', $request->name));
        $slug = $baseSlug;
        $counter = 1;

        // Check if slug already exists and make it unique, excluding current organization
        while (Organization::where('slug', $slug)->where('id', '!=', $organization->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $organization->update([
            'name' => $request->name,
            'slug' => $slug,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.organizations.index')->with('success', 'OPD berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('admin.organizations.index')->with('deleted', 'Organisasi berhasil dihapus.');
    }

    public function search(Request $request)
    {
        // Log the database connection name
        Log::info('Web request is using database: ' . DB::connection()->getDatabaseName());

        $searchTerm = $request->input('q');

        if (empty($searchTerm)) {
            return response()->json([]);
        }

        $locations = Organization::where('name', 'LIKE', "%{$searchTerm}%")
                                   ->limit(10)
                                   ->get(['id', 'name']);

        return response()->json($locations);
    }
}