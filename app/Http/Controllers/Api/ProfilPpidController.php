<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilPpid;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ProfilPpidController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $profil = ProfilPpid::where('status', true)->first() ?: ProfilPpid::orderBy('updated_at', 'desc')->first();

            if (!$profil) {
                return response()->json(['success' => false, 'error' => 'No profil found']);
            }

            $data = [
                'vision' => $profil->vision ?? 'Mewujudkan pelayanan informasi publik yang transparan, akuntabel, dan profesional.',
                'mission' => $profil->mission ?? [
                    'Meningkatkan kualitas pelayanan informasi publik.',
                    'Meningkatkan profesionalisme SDM pengelola informasi.',
                    'Memperkuat sarana dan prasarana layanan informasi.',
                    'Mendorong partisipasi masyarakat dalam pengawasan publik.'
                ],
                'phone' => $profil->phone ?? '085156878911',
                'email' => $profil->email ?? 'ppidkabsinjai@gmail.com',
                'address' => $profil->address ?? 'Jl. Persatuan Raya No. 5, Kec. Sinjai Utara, Kab. Sinjai',
                'maps_url' => $profil->maps_url ?? 'https://maps.app.goo.gl/N9S8J8vYvX3Z3Z3Z3',
                'instagram' => $profil->instagram,
                'facebook' => $profil->facebook,
                'twitter' => $profil->twitter,
                'tiktok' => $profil->tiktok,
                'youtube' => $profil->youtube,
                'website' => $profil->website,
                'structure_image' => $profil->structure_image ? url('storage/' . $profil->structure_image) : null,
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
