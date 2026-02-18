<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\ThemeSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $themeDefaults = config('theme.defaults', []);
            $themeRow = ThemeSetting::getActive();
            $colors = $themeRow ? $themeRow->toColorArray() : $themeDefaults;
            $primary = $colors['theme_primary'] ?? $themeDefaults['theme_primary'] ?? '#059669';
            $secondary = $colors['theme_secondary'] ?? $themeDefaults['theme_secondary'] ?? '#047857';
            $themeVars = [
                '--primary-green' => $primary,
                '--light-green' => $secondary,
                '--accent-green' => $colors['theme_accent'] ?? $themeDefaults['theme_accent'] ?? '#10B981',
                '--text-dark' => $colors['theme_text_dark'] ?? $themeDefaults['theme_text_dark'] ?? '#1a1a1a',
                '--text-light' => $colors['theme_text_light'] ?? $themeDefaults['theme_text_light'] ?? '#666',
                '--gradient-primary' => "linear-gradient(135deg, {$primary} 0%, {$secondary} 100%)",
                '--gradient-green' => "linear-gradient(135deg, {$primary} 0%, {$secondary} 100%)",
            ];
            foreach (config('theme.css_map', []) as $cssVar => $settingKey) {
                $themeVars['--' . $cssVar] = $colors[$settingKey] ?? $themeDefaults[$settingKey] ?? '#000';
            }

            $view->with([
                'siteTitle' => SiteSetting::get('site_title', config('app.name')),
                'siteTagline' => SiteSetting::get('site_tagline', ''),
                'siteLogo' => SiteSetting::get('logo') ? asset('storage/' . SiteSetting::get('logo')) : null,
                'contactEmail' => SiteSetting::get('contact_email', ''),
                'contactPhone' => SiteSetting::get('contact_phone', ''),
                'contactPhoneAlt' => SiteSetting::get('contact_phone_alt', ''),
                'siteAddress' => SiteSetting::get('address', ''),
                'workingHours' => SiteSetting::get('working_hours', ''),
                'footerAbout' => SiteSetting::get('footer_about', ''),
                'facebookUrl' => SiteSetting::get('facebook_url', '#'),
                'twitterUrl' => SiteSetting::get('twitter_url', '#'),
                'instagramUrl' => SiteSetting::get('instagram_url', '#'),
                'linkedinUrl' => SiteSetting::get('linkedin_url', '#'),
                'metaDescription' => SiteSetting::get('meta_description', ''),
                'themeCssVars' => $themeVars,
            ]);
        });
    }
}
