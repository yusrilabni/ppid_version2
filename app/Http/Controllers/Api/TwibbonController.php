<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Twibbon;

class TwibbonController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        
        $query = Twibbon::with('user')->orderBy('created_at', 'desc');

        if (!auth('sanctum')->check()) {
            $query->where('status', 'public');
        }

        $data = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function show($slug)
    {
        $twibbon = Twibbon::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();
            
        if ($twibbon->status === 'private' && !auth('sanctum')->check()) {
            abort(403, 'Akses ditolak. Twibbon ini bersifat private.');
        }

        return response()->json([
            'success' => true,
            'data' => $twibbon
        ]);
    }

    public function proxy(\Illuminate\Http\Request $request)
    {
        $path = $request->get('path');
        if (!$path) {
            return response()->json(['error' => 'Path required'], 400);
        }
        
        // Validasi path agar hanya melayani twibbon
        if (!\Illuminate\Support\Str::startsWith($path, 'twibbon/')) {
            return response()->json(['error' => 'Invalid path'], 403);
        }

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $file = \Illuminate\Support\Facades\Storage::disk('public')->get($path);
        $mime = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mime)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS');
    }

    public function saveSession(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
            'result_image' => 'required|file|image',
            'raw_images' => 'nullable|array',
            'raw_images.*' => 'file|image'
        ]);

        $twibbon = Twibbon::where('slug', $request->slug)->orWhere('id', $request->slug)->first();
        $twibbonId = $twibbon ? $twibbon->id : null;

        $resultPath = $request->file('result_image')->store('twibbon-sessions/results', 'public');

        $session = \App\Models\TwibbonSession::create([
            'twibbon_id' => $twibbonId,
            'result_image_path' => $resultPath
        ]);

        if ($request->hasFile('raw_images')) {
            foreach ($request->file('raw_images') as $file) {
                $rawPath = $file->store('twibbon-sessions/raw', 'public');
                \App\Models\TwibbonSessionPhoto::create([
                    'twibbon_session_id' => $session->id,
                    'raw_image_path' => $rawPath
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Session saved successfully.'
        ]);
    }
}
