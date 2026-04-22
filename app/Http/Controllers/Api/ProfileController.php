<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller {
    public function index(): JsonResponse {
        $profile = Organization::first();
        return response()->json(["success" => true, "data" => $profile]);
    }
}
