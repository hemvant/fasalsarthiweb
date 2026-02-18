<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\ThemeSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    private array $keys = [
        'site_title',
        'site_tagline',
        'logo',
        'contact_email',
        'contact_phone',
        'contact_phone_alt',
        'address',
        'footer_about',
        'meta_description',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'working_hours',
        // Home page
        'hero_title_prefix',
        'hero_title_highlight',
        'hero_subtitle',
        'hero_cta_text',
        'hero_stat1_number',
        'hero_stat1_label',
        'hero_stat2_number',
        'hero_stat2_label',
        'hero_stat3_number',
        'hero_stat3_label',
        'features_title',
        'features_subtitle',
        'experience_title',
        'experience_subtitle',
        'experience_btn_text',
        'testimonials_title',
        'testimonials_subtitle',
        'testimonial1_quote',
        'testimonial1_name',
        'testimonial1_role',
        'testimonial2_quote',
        'testimonial2_name',
        'testimonial2_role',
        'testimonial3_quote',
        'testimonial3_name',
        'testimonial3_role',
        'cta_title',
        'cta_subtitle',
        'cta_stat1_number',
        'cta_stat1_label',
        'cta_stat2_number',
        'cta_stat2_label',
        'cta_stat3_number',
        'cta_stat3_label',
        'final_cta_title',
        'final_cta_subtitle',
        'final_cta_btn_primary',
        'final_cta_btn_secondary',
    ];

    public function edit(): View
    {
        $settings = SiteSetting::getMany($this->keys);
        $theme = ThemeSetting::getActive();
        if ($theme) {
            $settings = array_merge($settings, $theme->toColorArray());
        }
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'site_title' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:50',
            'contact_phone_alt' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'footer_about' => 'nullable|string',
            'meta_description' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'working_hours' => 'nullable|string|max:255',
            'hero_title_prefix' => 'nullable|string|max:100',
            'hero_title_highlight' => 'nullable|string|max:100',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_cta_text' => 'nullable|string|max:100',
            'hero_stat1_number' => 'nullable|string|max:50',
            'hero_stat1_label' => 'nullable|string|max:100',
            'hero_stat2_number' => 'nullable|string|max:50',
            'hero_stat2_label' => 'nullable|string|max:100',
            'hero_stat3_number' => 'nullable|string|max:50',
            'hero_stat3_label' => 'nullable|string|max:100',
            'features_title' => 'nullable|string|max:255',
            'features_subtitle' => 'nullable|string|max:500',
            'experience_title' => 'nullable|string|max:255',
            'experience_subtitle' => 'nullable|string|max:500',
            'experience_btn_text' => 'nullable|string|max:100',
            'testimonials_title' => 'nullable|string|max:255',
            'testimonials_subtitle' => 'nullable|string|max:500',
            'testimonial1_quote' => 'nullable|string',
            'testimonial1_name' => 'nullable|string|max:100',
            'testimonial1_role' => 'nullable|string|max:100',
            'testimonial2_quote' => 'nullable|string',
            'testimonial2_name' => 'nullable|string|max:100',
            'testimonial2_role' => 'nullable|string|max:100',
            'testimonial3_quote' => 'nullable|string',
            'testimonial3_name' => 'nullable|string|max:100',
            'testimonial3_role' => 'nullable|string|max:100',
            'cta_title' => 'nullable|string|max:255',
            'cta_subtitle' => 'nullable|string|max:500',
            'cta_stat1_number' => 'nullable|string|max:50',
            'cta_stat1_label' => 'nullable|string|max:100',
            'cta_stat2_number' => 'nullable|string|max:50',
            'cta_stat2_label' => 'nullable|string|max:100',
            'cta_stat3_number' => 'nullable|string|max:50',
            'cta_stat3_label' => 'nullable|string|max:100',
            'final_cta_title' => 'nullable|string|max:255',
            'final_cta_subtitle' => 'nullable|string|max:500',
            'final_cta_btn_primary' => 'nullable|string|max:100',
            'final_cta_btn_secondary' => 'nullable|string|max:100',
            'theme_primary' => 'nullable|string|max:20',
            'theme_secondary' => 'nullable|string|max:20',
            'theme_accent' => 'nullable|string|max:20',
            'theme_text_dark' => 'nullable|string|max:20',
            'theme_text_light' => 'nullable|string|max:20',
            'theme_background' => 'nullable|string|max:20',
            'theme_success' => 'nullable|string|max:20',
            'theme_warning' => 'nullable|string|max:20',
            'theme_error' => 'nullable|string|max:20',
        ];
        $data = $request->validate($rules);

        $themeKeys = [
            'theme_primary' => 'primary_color',
            'theme_secondary' => 'secondary_color',
            'theme_accent' => 'accent_color',
            'theme_text_dark' => 'text_dark_color',
            'theme_text_light' => 'text_light_color',
            'theme_background' => 'background_color',
            'theme_success' => 'success_color',
            'theme_warning' => 'warning_color',
            'theme_error' => 'error_color',
        ];
        $themeData = [];
        foreach ($themeKeys as $requestKey => $column) {
            if (array_key_exists($requestKey, $data)) {
                $themeData[$column] = $data[$requestKey] ?? null;
                unset($data[$requestKey]);
            }
        }

        foreach ($data as $key => $value) {
            if ($key === 'logo') {
                if ($request->hasFile('logo')) {
                    $old = SiteSetting::get('logo');
                    if ($old) {
                        Storage::disk('public')->delete($old);
                    }
                    $path = $request->file('logo')->store('settings', 'public');
                    SiteSetting::set($key, $path);
                }
            } else {
                SiteSetting::set($key, $value ?? '');
            }
        }

        if (!empty($themeData)) {
            $theme = ThemeSetting::first();
            if ($theme) {
                $theme->update($themeData);
            } else {
                ThemeSetting::create(array_merge($themeData, [
                    'primary_color' => $themeData['primary_color'] ?? '#059669',
                    'secondary_color' => $themeData['secondary_color'] ?? '#047857',
                    'accent_color' => $themeData['accent_color'] ?? '#10B981',
                    'text_dark_color' => $themeData['text_dark_color'] ?? '#1a1a1a',
                    'text_light_color' => $themeData['text_light_color'] ?? '#666666',
                    'background_color' => $themeData['background_color'] ?? '#ffffff',
                    'success_color' => $themeData['success_color'] ?? '#10B981',
                    'warning_color' => $themeData['warning_color'] ?? '#F59E0B',
                    'error_color' => $themeData['error_color'] ?? '#EF4444',
                ]));
            }
        }

        if ($request->has('remove_logo') && $request->remove_logo) {
            $old = SiteSetting::get('logo');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            SiteSetting::set('logo', null);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully.');
    }
}
