<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiSetting;
use Illuminate\Http\Request;

class AiSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = AiSetting::all();
        return view('admin.ai_settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ai_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'boolean'
        ]);

        AiSetting::create([
            'provider' => $request->provider,
            'model' => $request->model,
            'api_key' => $request->api_key,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AiSetting $aiSetting)
    {
        return view('admin.ai_settings.edit', compact('aiSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AiSetting $aiSetting)
    {
        $request->validate([
            'provider' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $aiSetting->update([
            'provider' => $request->provider,
            'model' => $request->model,
            'api_key' => $request->api_key,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiSetting $aiSetting)
    {
        $aiSetting->delete();
        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting deleted successfully.');
    }
}
