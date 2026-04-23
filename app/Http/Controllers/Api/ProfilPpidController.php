<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilPpid;
use Illuminate\Http\JsonResponse;

class ProfilPpidController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $profil = ProfilPpid::where('status', true)->first() ?: ProfilPpid::first();

            return response()->json([
                'success' => true,
                'data' => $profil
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
