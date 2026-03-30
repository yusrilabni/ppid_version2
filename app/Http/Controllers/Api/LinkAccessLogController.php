<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LinkAccessLog; // Import the model
use Carbon\Carbon; // Import Carbon

class LinkAccessLogController extends Controller
{
    public function logAccess(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
            'title' => 'required|string|max:255',
        ]);

        $linkLog = LinkAccessLog::firstOrCreate(
            ['url' => $request->url],
            ['title' => $request->title, 'access_count' => 0]
        );

        $linkLog->increment('access_count');
        $linkLog->update(['last_accessed_at' => Carbon::now()]);

        return response()->json(['message' => 'Link access logged successfully.'], 200);
    }
}
