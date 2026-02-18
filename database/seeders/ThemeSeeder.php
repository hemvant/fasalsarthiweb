<?php

namespace Database\Seeders;

use App\Models\ThemeSetting;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        if (ThemeSetting::exists()) {
            return;
        }
        ThemeSetting::create([
            'name' => 'Default',
            'primary_color' => '#059669',
            'secondary_color' => '#047857',
            'accent_color' => '#10B981',
            'text_dark_color' => '#1a1a1a',
            'text_light_color' => '#666666',
            'background_color' => '#ffffff',
            'success_color' => '#10B981',
            'warning_color' => '#F59E0B',
            'error_color' => '#EF4444',
            'is_active' => true,
        ]);
    }
}
