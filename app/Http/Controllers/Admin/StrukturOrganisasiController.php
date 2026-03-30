<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\StrukturOrganisasi;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Facades\Gate;

class StrukturOrganisasiController extends Controller
{
    /**
     * Show the form for managing the organizational structure.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function manage(Organization $organization)
    {
        Gate::authorize('manage-structure', $organization);

        $struktur = StrukturOrganisasi::firstOrCreate(
            ['organization_id' => $organization->id],
            ['title' => 'Struktur ' . $organization->name]
        );

        return view('admin.struktur.manage', compact('organization', 'struktur'));
    }

    public function myStructure()
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $organization = Organization::where('unit_id', $user->unit_id)->first();
        if (!$organization) {
            abort(404, 'Organisasi tidak ditemukan untuk unit Anda.');
        }

        Gate::authorize('manage-structure', $organization);

        $struktur = StrukturOrganisasi::firstOrCreate(
            ['organization_id' => $organization->id],
            ['title' => 'Struktur ' . $organization->name]
        );

        return view('admin.struktur.my-manage', compact('organization', 'struktur'));
    }

    /**
     * Update the organizational structure details in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        Gate::authorize('manage-structure', $organization);

        $request->validate([
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // 10 MB
            'website_url' => 'nullable|url', // Add this line
        ]);

        $struktur = StrukturOrganisasi::firstOrCreate(
            ['organization_id' => $organization->id]
        );

        if ($request->hasFile('structure_image')) {
            $path = $this->processImage($request->file('structure_image'), 'struktur_organisasi');
            if ($struktur->image_path) {
                Storage::disk('public')->delete($struktur->image_path);
            }
            $struktur->image_path = $path;
        }
        
        $struktur->title = 'Struktur ' . $organization->name;
        $struktur->save();

        // Save the website_url to the organization
        $organization->website_url = $request->website_url;
        $organization->save(); // Save the organization model

        // Now, update or create the corresponding Informasi record with hardcoded values
        if ($struktur->image_path) { // Only create/update if there is an image
            Informasi::updateOrCreate(
                [
                    'content' => 'struktur_organisasi_' . $organization->id, // A unique identifier for this org's structure
                ],
                [
                    'title' => 'Struktur Informasi ' . $organization->name,
                    'deskripsi' => 'berasal dari struktur informasi yang berisi struktur organisasi ' . $organization->name,
                    'file' => $struktur->image_path,
                    'status' => 'aktif',
                    'category' => 'Informasi Berkala', // Hardcoded
                    'jenis_dokumen' => 'Profil Badan Publik', // Hardcoded
                    'user_id' => Auth::id(),
                    'unit_id' => $organization->unit_id ?? Auth::user()->unit_id,
                    'tahun' => now()->year,
                    'tanggal_upload' => now()->toDateString(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    public function updateMyStructure(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $organization = Organization::where('unit_id', $user->unit_id)->firstOrFail();

        Gate::authorize('manage-structure', $organization);

        $request->validate([
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $struktur = StrukturOrganisasi::firstOrCreate(
            ['organization_id' => $organization->id]
        );

        if ($request->hasFile('structure_image')) {
            $path = $this->processImage($request->file('structure_image'), 'struktur_organisasi');
            if ($struktur->image_path) {
                Storage::disk('public')->delete($struktur->image_path);
            }
            $struktur->image_path = $path;
        }

        $struktur->title = 'Struktur ' . $organization->name;
        $struktur->save();

        if ($struktur->image_path) {
            Informasi::updateOrCreate(
                ['content' => 'struktur_organisasi_' . $organization->id],
                [
                    'title' => 'Struktur Informasi ' . $organization->name,
                    'deskripsi' => 'berasal dari struktur informasi yang berisi struktur organisasi ' . $organization->name,
                    'file' => $struktur->image_path,
                    'status' => 'aktif',
                    'category' => 'Informasi Berkala',
                    'jenis_dokumen' => 'Profil Badan Publik',
                    'user_id' => Auth::id(),
                    'unit_id' => $organization->unit_id ?? Auth::user()->unit_id,
                    'tahun' => now()->year,
                    'tanggal_upload' => now()->toDateString(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    /**
     * Process the uploaded image: convert to WebP and save.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string The path to the saved image.
     */
    private function processImage($file, $directory)
    {
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager->read($file->path());

        // Encode the image to WebP format with 80% quality
        $encodedImage = $image->toWebp(80);

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.webp';
        $path = $directory . '/' . $fileName;

        Storage::disk('public')->put($path, (string) $encodedImage);

        return $path;
    }
}

