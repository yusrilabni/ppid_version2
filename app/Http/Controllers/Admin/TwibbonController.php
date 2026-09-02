<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Twibbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TwibbonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|image|mimes:png,jpg,jpeg,webp|max:10240', // Max 10MB
        ]);

        try {
            $user = Auth::user();
            
            if (!$user->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya Super Admin yang dapat mengunggah Twibbon.'
                ], 403);
            }

            $file = $request->file('file');
            
            // Konversi ke WebP untuk performa tinggi
            ini_set('memory_limit', '512M');
            $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $imageInstance = $imageManager->read($file->path());
            $imageInstance = $imageInstance->toWebp(90);
            
            $imagePath = tempnam(sys_get_temp_dir(), 'twibbon_') . '.webp';
            $imageInstance->save($imagePath);
            
            $fileName = \Illuminate\Support\Str::slug($request->judul) . '_' . time() . '.webp';
            $filePath = 'twibbon/' . $fileName;
            
            Storage::disk('public')->put($filePath, file_get_contents($imagePath));
            unlink($imagePath);

            $twibbon = Twibbon::create([
                'judul' => $request->judul,
                'file_path' => $filePath,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Twibbon berhasil ditambahkan.',
                'data' => $twibbon
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            
            if (!$user->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.'
                ], 403);
            }

            $twibbon = Twibbon::findOrFail($id);

            if ($twibbon->file_path && Storage::disk('public')->exists($twibbon->file_path)) {
                Storage::disk('public')->delete($twibbon->file_path);
            }

            $twibbon->delete();

            return response()->json([
                'success' => true,
                'message' => 'Twibbon berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Twibbon: ' . $e->getMessage()
            ], 500);
        }
    }
}
