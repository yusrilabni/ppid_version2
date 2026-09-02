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
            'slug' => 'required|string|max:255|unique:twibbons,slug',
            'status' => 'required|in:public,private',
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
            
            $fileName = \Illuminate\Support\Str::slug($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('twibbon', $fileName, 'public');

            $twibbon = Twibbon::create([
                'judul' => $request->judul,
                'slug' => \Illuminate\Support\Str::slug($request->slug),
                'status' => $request->status,
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

    public function update(Request $request, $slug)
    {
        $twibbon = Twibbon::where('slug', $slug)->firstOrFail();
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:twibbons,slug,' . $twibbon->id,
            'status' => 'required|in:public,private',
            'file' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240', // Max 10MB
        ]);

        try {
            $user = Auth::user();
            
            if (!$user->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya Super Admin yang dapat mengubah Twibbon.'
                ], 403);
            }

            $twibbon->judul = $request->judul;
            $twibbon->slug = \Illuminate\Support\Str::slug($request->slug);
            $twibbon->status = $request->status;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                $fileName = \Illuminate\Support\Str::slug($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('twibbon', $fileName, 'public');

                if ($twibbon->file_path && Storage::disk('public')->exists($twibbon->file_path)) {
                    Storage::disk('public')->delete($twibbon->file_path);
                }

                $twibbon->file_path = $filePath;
            }

            $twibbon->save();

            return response()->json([
                'success' => true,
                'message' => 'Twibbon berhasil diperbarui.',
                'data' => $twibbon
            ]);

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
