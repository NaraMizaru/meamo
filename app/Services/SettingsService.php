<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public static function get(string $key, $default = null)
    {
        // Cache for 60 minutes
        return Cache::remember("setting_{$key}", 60, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        Cache::forget("setting_{$key}");
    }
}
