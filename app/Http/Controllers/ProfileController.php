<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\GeneralHelper;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Coba ambil data dari session dulu, jika tidak ada, baru panggil API
        $apiData = session()->pull('api_data');
        if (!$apiData) {
            $apiData = User::getDataFromApi($user->nip);
        }

        // GET UNIT DATA FROM API to ensure correct unit information
        $allUnits = $this->getUnitData();

        // 1. Resolve unit name from apiData if available
        if ($apiData && isset($apiData['unit_id'])) {
            foreach ($allUnits as $unit) {
                if (isset($unit['unit_id']) && $unit['unit_id'] == $apiData['unit_id']) {
                    $apiData['unit_nama'] = $unit['unit_nama'] ?? $apiData['unit_nama'] ?? 'Tidak Diketahui';
                    break;
                }
            }
        }
        
        // 2. Resolve unit name from user model if apiData is missing or doesn't have unit_nama
        if (empty($apiData['unit_nama']) && !empty($user->unit_id)) {
            $userUnit = $allUnits->get($user->unit_id);
            if ($userUnit) {
                $apiData['unit_nama'] = $userUnit['unit_nama'];
            }
        }

        return view('profile.edit', [
            'user' => $user,
            'apiData' => $apiData ?? [],
            'allUnits' => $allUnits,
        ]);
    }

    // Method to fetch unit data from API
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, ImageManager $imageManager): RedirectResponse
    {
        $user = $request->user();

        // Fill model with validated data (email, bio, social links)
        $user->fill($request->validated());

        // If user updated their email, mark it as unverified
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle the photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $imageFile = $request->file('photo');
            $filename = Str::uuid() . '.webp';
            $path = 'profile-photos/' . $filename;

            // Process and save the new image
            $image = $imageManager->read($imageFile)->scaleDown(1024, 1024)->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put($path, (string) $image);
            $user->profile_photo_path = $path;
        }
        
        // If a NIP was submitted, update it
        if ($request->filled('nip')) {
            $user->nip = $request->nip;
        }
        
        // Save all changes to the user
        $user->save();
        
        // Set the success message
        $statusMessage = 'profile-updated';
        if ($user->wasChanged('email')) {
             $statusMessage = 'email-updated';
        }

        return Redirect::route('profile.edit')->with('status', $statusMessage);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
