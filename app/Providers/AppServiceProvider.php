<?php

namespace App\Providers;

use App\Models\SiteSetting;
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
            ]);
        });
    }
}
