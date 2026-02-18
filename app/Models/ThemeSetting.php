<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ThemeSetting extends Model
{
    protected $table = 'theme_settings';

    protected $fillable = [
        'name',
        'primary_color',
        'secondary_color',
        'accent_color',
        'text_dark_color',
        'text_light_color',
        'background_color',
        'success_color',
        'warning_color',
        'error_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Get the active theme (single row). Uses cache. */
    public static function getActive(): ?self
    {
        return Cache::remember('theme_settings_active', 3600, function () {
            return self::where('is_active', true)->first() ?? self::first();
        });
    }

    /** Clear theme cache (call after update). */
    public static function clearCache(): void
    {
        Cache::forget('theme_settings_active');
    }

    /** Get all colors as key => value (theme_primary => #hex, etc.). */
    public function toColorArray(): array
    {
        return [
            'theme_primary' => $this->primary_color,
            'theme_secondary' => $this->secondary_color,
            'theme_accent' => $this->accent_color,
            'theme_text_dark' => $this->text_dark_color,
            'theme_text_light' => $this->text_light_color,
            'theme_background' => $this->background_color,
            'theme_success' => $this->success_color,
            'theme_warning' => $this->warning_color,
            'theme_error' => $this->error_color,
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::clearCache());
        static::deleted(fn () => self::clearCache());
    }
}
