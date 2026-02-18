<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    /**
     * Return theme colors (for mobile app or any client). Public.
     */
    public function index(): JsonResponse
    {
        $defaults = config('theme.defaults', []);
        $row = ThemeSetting::getActive();
        $theme = $row ? $row->toColorArray() : $defaults;
        $primary = $theme['theme_primary'] ?? $defaults['theme_primary'] ?? '#059669';
        $secondary = $theme['theme_secondary'] ?? $defaults['theme_secondary'] ?? '#047857';
        $theme['gradient_primary'] = "linear-gradient(135deg, {$primary} 0%, {$secondary} 100%)";
        return response()->json(['theme' => $theme]);
    }
}
