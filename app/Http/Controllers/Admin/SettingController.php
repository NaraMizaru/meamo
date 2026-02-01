<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request, SettingsService $settingsService)
    {
        $validated = $request->validate([
            'booking_duration_minutes' => 'required|integer|min:1',
            // Add other settings here as needed
        ]);

        foreach ($validated as $key => $value) {
            $settingsService->set($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
