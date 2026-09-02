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
        $data = Twibbon::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

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

        return response()->json([
            'success' => true,
            'data' => $twibbon
        ]);
    }
}
