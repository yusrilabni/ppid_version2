<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Import the Setting model

class AdminSettingController extends Controller
{
    public function showSliderSettings()
    {
        $sliderTransitionDuration = Setting::where('key', 'slider_transition_duration_ms')->first();
        $durationInSeconds = ($sliderTransitionDuration ? $sliderTransitionDuration->value : 5000) / 1000; // Default to 5 seconds

        return view('admin.settings.slider', compact('durationInSeconds'));
    }

    public function updateSliderSettings(Request $request)
    {
        $request->validate([
            'duration_in_seconds' => 'required|integer|min:1',
        ]);

        $durationInMs = $request->duration_in_seconds * 1000;

        Setting::updateOrCreate(
            ['key' => 'slider_transition_duration_ms'],
            ['value' => $durationInMs]
        );

        return redirect()->back()->with('success', 'Pengaturan durasi transisi slider berhasil diperbarui.');
    }
}
