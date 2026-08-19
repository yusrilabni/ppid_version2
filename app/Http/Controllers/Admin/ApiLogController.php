<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiLog;
use Illuminate\Http\Request;

class ApiLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ApiLog::with('user')->latest();

        if ($request->filled('risk_level')) {
            $query->where('risk_level', $request->risk_level);
        }

        $apiLogs = $query->paginate(20);

        return view('admin.api-logs.index', compact('apiLogs'));
    }
}
