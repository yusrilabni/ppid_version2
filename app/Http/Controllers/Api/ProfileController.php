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

        // Logic for Pangkat
        $pangkat = null;
        if (!empty($apiData)) {
            $pangkat = trim(($apiData['pangkat_nama'] ?? '') . ' ' . ($apiData['pangkat_golruang'] ?? ''));
            if ($pangkat === '()') $pangkat = null;
        }

        // GET UNIT DATA FROM API to ensure correct unit information
        $allUnits = GeneralHelper::getUnitData();

        if (!empty($apiData) && isset($apiData['unit_id'])) {
            foreach ($allUnits as $unit) {
                if (isset($unit['unit_id']) && $unit['unit_id'] == $apiData['unit_id']) {
                    $apiData['unit_nama'] = $unit['unit_nama'] ?? null;
                    break;
                }
            }
        }
        if (empty($apiData['unit_nama']) && !empty($user->unit_id)) {
            $userUnit = $allUnits->get($user->unit_id);
            if ($userUnit) {
                $apiData['unit_nama'] = $userUnit['unit_nama'];
            }
        }

        // Final Profile Photo Logic (Same as Web)
        $photoUrl = null;
        if (!empty($apiData['foto'])) {
            $photoUrl = $apiData['foto'];
        } elseif ($user->profile_photo_path) {
            $photoUrl = asset('storage/' . $user->profile_photo_path);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'is_asn' => !empty($apiData['nip']),
                'kepegawaian' => [
                    'pangkat' => $pangkat,
                    'jabatan' => $apiData['jabatan_nama'] ?? null,
                    'unit_bagian' => $apiData['jabatan_grup'] ?? null,
                    'unit_kerja' => $apiData['unit_nama'] ?? null,
                    'nomor_hp' => $apiData['nomor_hp'] ?? null,
                ],
                'profile_photo_url' => $photoUrl
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

        // Fill data
        $user->fill($request->only([
            'name', 'email', 'nip', 'bio', 'facebook', 'instagram', 'tiktok', 'linkedin'
        ]));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle Photo
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
