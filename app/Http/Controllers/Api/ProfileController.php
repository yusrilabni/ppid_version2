<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\GeneralHelper;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's profile data.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        
        // Data dari API eksternal jika ada NIP
        $apiData = User::getDataFromApi($user->nip);

        // Ambil data unit untuk mendapatkan nama dinas
        $allUnits = GeneralHelper::getUnitData();
        $unitNama = null;

        if ($apiData && isset($apiData['unit_id'])) {
            foreach ($allUnits as $unit) {
                if (isset($unit['unit_id']) && $unit['unit_id'] == $apiData['unit_id']) {
                    $unitNama = $unit['unit_nama'] ?? null;
                    break;
                }
            }
        }

        if (!$unitNama && $user->unit_id) {
            $userUnit = $allUnits->get($user->unit_id);
            if ($userUnit) {
                $unitNama = $userUnit['unit_nama'];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'external_data' => $apiData,
                'unit_name' => $unitNama,
                'profile_photo_url' => $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null
            ]
        ]);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request, ImageManager $imageManager)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'nip' => 'sometimes|nullable|string',
            'bio' => 'sometimes|nullable|string',
            'facebook' => 'sometimes|nullable|string',
            'instagram' => 'sometimes|nullable|string',
            'tiktok' => 'sometimes|nullable|string',
            'linkedin' => 'sometimes|nullable|string',
            'photo' => 'sometimes|nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->fill($request->only([
            'name', 'email', 'nip', 'bio', 'facebook', 'instagram', 'tiktok', 'linkedin'
        ]));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $imageFile = $request->file('photo');
            $filename = Str::uuid() . '.webp';
            $path = 'profile-photos/' . $filename;

            $image = $imageManager->read($imageFile)->scaleDown(1024, 1024)->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put($path, (string) $image);
            $user->profile_photo_path = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => [
                'user' => $user,
                'profile_photo_url' => $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null
            ]
        ]);
    }
}
