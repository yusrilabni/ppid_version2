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
        $durationInSeconds = ($sliderTransitionDuration ? $sliderTransitionDuration->value : 5000) / 1000;

        $aspectRatio = Setting::where('key', 'slider_aspect_ratio')->first()->value ?? 'aspect-video';
        $animationType = Setting::where('key', 'slider_animation_type')->first()->value ?? 'slide';

        return view('admin.settings.slider', compact('durationInSeconds', 'aspectRatio', 'animationType'));
    }

    public function updateSliderSettings(Request $request)
    {
        $request->validate([
            'duration_in_seconds' => 'required|integer|min:1',
            'aspect_ratio' => 'required|string',
            'animation_type' => 'required|string',
        ]);

        Setting::updateOrCreate(['key' => 'slider_transition_duration_ms'], ['value' => $request->duration_in_seconds * 1000]);
        Setting::updateOrCreate(['key' => 'slider_aspect_ratio'], ['value' => $request->aspect_ratio]);
        Setting::updateOrCreate(['key' => 'slider_animation_type'], ['value' => $request->animation_type]);

        return redirect()->back()->with('success', 'Pengaturan slider berhasil diperbarui.');
    }
}
