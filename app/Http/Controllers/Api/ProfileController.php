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
        $isManualPhoto = false;
        
        if (!empty($apiData['foto'])) {
            $photoUrl = $apiData['foto'];
        } elseif ($user->profile_photo_path) {
            $photoUrl = str_starts_with($user->profile_photo_path, 'http') ? $user->profile_photo_path : asset('storage/' . $user->profile_photo_path);
            if (!str_starts_with($user->profile_photo_path, 'http')) {
                $isManualPhoto = true;
            }
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
                'profile_photo_url' => $photoUrl,
                'is_manual_photo' => $isManualPhoto
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
            'email' => 'sometimes|nullable|email|unique:users,email,' . $user->id,
            'nip' => 'sometimes|nullable|string',
            'bio' => 'sometimes|nullable|string',
            'facebook' => 'sometimes|nullable|string',
            'instagram' => 'sometimes|nullable|string',
            'tiktok' => 'sometimes|nullable|string',
            'linkedin' => 'sometimes|nullable|string',
            'photo' => 'sometimes|nullable|image|max:2048',
            'remove_photo' => 'sometimes|boolean',
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
        if ($request->boolean('remove_photo')) {
            if ($user->profile_photo_path && !str_starts_with($user->profile_photo_path, 'http')) {
                Storage::disk('public')->delete($user->profile_photo_path);
                $user->profile_photo_path = null;
            }
        } elseif ($request->hasFile('photo')) {
            if ($user->profile_photo_path && !str_starts_with($user->profile_photo_path, 'http')) {
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
        
        $isManualPhoto = $user->profile_photo_path && !str_starts_with($user->profile_photo_path, 'http');

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => [
                'user' => $user,
                'profile_photo_url' => $user->profile_photo_path ? (str_starts_with($user->profile_photo_path, 'http') ? $user->profile_photo_path : asset('storage/' . $user->profile_photo_path)) : null,
                'is_manual_photo' => $isManualPhoto
            ]
        ]);
    }

    /**
     * Merge current account with another account.
     */
    public function mergeAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string', // can be email or NIP
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $currentUser = $request->user();

        // Cari akun target berdasarkan email atau nip
        $targetUser = User::where('email', $request->identifier)
            ->orWhere('nip', $request->identifier)
            ->first();

        if (!$targetUser) {
            return response()->json([
                'success' => false,
                'message' => 'Akun target tidak ditemukan. Pastikan Email atau NIP benar.'
            ], 404);
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $targetUser->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Katasandi akun target salah.'
            ], 403);
        }

        if ($targetUser->id === $currentUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menggabungkan dengan akun yang sama.'
            ], 400);
        }

        $role1 = $currentUser->role;
        $role2 = $targetUser->role;
        
        $roles = [$role1, $role2];
        
        if (in_array('user', $roles) && (in_array('admin', $roles) || in_array('superadmin', $roles))) {
            // Valid combination
        } else {
            return response()->json([
                'success' => false,
                'message' => "Tidak diizinkan menggabungkan akun sesama role (misal Admin dengan Admin, atau User dengan User), atau Superadmin dengan Admin."
            ], 403);
        }

        // Tentukan mana yang akan dipertahankan (yang punya role lebih tinggi)
        if ($targetUser->role === 'superadmin' || ($targetUser->role === 'admin' && $currentUser->role === 'user')) {
            $keptUser = clone $targetUser;
            $deletedUser = clone $currentUser;
        } else {
            $keptUser = clone $currentUser;
            $deletedUser = clone $targetUser;
        }

        // Pindahkan google_id jika ada
        if ($deletedUser->google_id && !$keptUser->google_id) {
            $keptUser->google_id = $deletedUser->google_id;
        }
        
        // Pindahkan NIP jika ada
        if (!$keptUser->nip && $deletedUser->nip) {
            $keptUser->nip = $deletedUser->nip;
        }

        // Simpan keptUser
        User::where('id', $keptUser->id)->update([
            'google_id' => $keptUser->google_id,
            'nip' => $keptUser->nip
        ]);

        // Pindahkan relasi penting lainnya (jika ada, misal permohonan informasi)
        \App\Models\PermohonanInformasi::where('user_id', $deletedUser->id)->update(['user_id' => $keptUser->id]);

        // Hapus akun lama (yang inferior)
        User::where('id', $deletedUser->id)->delete();

        // Buat token baru untuk keptUser
        $keptUserObj = User::find($keptUser->id);
        
        // Hapus token lama untuk keamanan
        if (method_exists($keptUserObj, 'tokens')) {
            $keptUserObj->tokens()->delete();
        }
        $token = $keptUserObj->createToken('merged-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil digabungkan.',
            'user' => $keptUserObj,
            'token' => $token
        ]);
    }
}
