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
            $data = Cache::rememberForever('all_profil_ppid', function () {
                $profil = ProfilPpid::where('status', true)->first() ?: ProfilPpid::first();

                return [
                    'vision' => $profil->vision ?? 'Mewujudkan pelayanan informasi publik yang transparan, akuntabel, dan profesional.',
                    'mission' => $profil->mission ?? [
                        'Meningkatkan kualitas pelayanan informasi publik.',
                        'Meningkatkan profesionalisme SDM pengelola informasi.',
                        'Memperkuat sarana dan prasarana layanan informasi.',
                        'Mendorong partisipasi masyarakat dalam pengawasan publik.'
                    ],
                    'phone' => '085156878911',
                    'email' => 'ppidkabsinjai@gmail.com',
                    'address' => $profil->address ?? 'Jl. Persatuan Raya No. 5, Kec. Sinjai Utara, Kab. Sinjai',
                    'maps_url' => $profil->maps_url ?? 'https://maps.app.goo.gl/N9S8J8vYvX3Z3Z3Z3',
                    'instagram' => $profil->instagram ?? 'https://www.instagram.com/ppidkabsinjai',
                    'facebook' => $profil->facebook ?? 'https://www.facebook.com/ppidkabsinjai',
                    'twitter' => $profil->twitter ?? 'https://twitter.com/ppidkabsinjai',
                    'youtube' => $profil->youtube ?? 'https://www.youtube.com/@ppidkabsinjai',
                    'website' => 'https://ppidkab.sinjaikab.go.id',
                    'structure_image' => $profil->structure_image ? url('storage/' . $profil->structure_image) : null,
                ];
            });

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
