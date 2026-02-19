<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Crop;
use App\Models\Feature;
use App\Models\CropCategory;
use App\Models\IrrigationCategory;
use App\Models\IrrigationMethod;
use App\Models\Page;
use App\Models\Scheme;
use App\Models\SchemeCategory;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PageController extends Controller
{
    private static function homeSettingKeys(): array
    {
        return [
            'hero_title_prefix', 'hero_title_highlight', 'hero_subtitle', 'hero_cta_text',
            'hero_stat1_number', 'hero_stat1_label', 'hero_stat2_number', 'hero_stat2_label', 'hero_stat3_number', 'hero_stat3_label',
            'features_title', 'features_subtitle',
            'experience_title', 'experience_subtitle', 'experience_btn_text',
            'testimonials_title', 'testimonials_subtitle',
            'testimonial1_quote', 'testimonial1_name', 'testimonial1_role',
            'testimonial2_quote', 'testimonial2_name', 'testimonial2_role',
            'testimonial3_quote', 'testimonial3_name', 'testimonial3_role',
            'cta_title', 'cta_subtitle', 'cta_stat1_number', 'cta_stat1_label', 'cta_stat2_number', 'cta_stat2_label', 'cta_stat3_number', 'cta_stat3_label',
            'final_cta_title', 'final_cta_subtitle', 'final_cta_btn_primary', 'final_cta_btn_secondary',
        ];
    }

    public function home(): View
    {
        $home = SiteSetting::getMany(self::homeSettingKeys());
        $featuredCrops = Crop::with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->limit(6)
            ->get();
        $latestPosts = BlogPost::with('category')
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
        $stats = [
            'crops_count' => Crop::where('is_active', true)->count(),
            'schemes_count' => Scheme::where('is_active', true)->count(),
            'blog_count' => BlogPost::where('is_active', true)->count(),
        ];
        $features = Feature::where('is_active', true)->orderBy('sort_order')->orderBy('title')->limit(6)->get();
        return view('pages.home', compact('home', 'featuredCrops', 'latestPosts', 'stats', 'features'));
    }

    public function featureIndex(): View
    {
        $home = SiteSetting::getMany(['features_title', 'features_subtitle']);
        $features = Feature::where('is_active', true)->orderBy('sort_order')->orderBy('title')->get();
        $latestPosts = BlogPost::with('category')->where('is_active', true)->whereNotNull('published_at')->orderBy('published_at', 'desc')->limit(3)->get();
        return view('pages.feature', compact('home', 'features', 'latestPosts'));
    }

    public function featureShow(string $slug): View|Response
    {
        $feature = Feature::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedFeatures = Feature::where('is_active', true)->where('id', '!=', $feature->id)->orderBy('sort_order')->orderBy('title')->limit(3)->get();
        return view('pages.feature-detail', compact('feature', 'relatedFeatures'));
    }

    public function schemeIndex(): View
    {
        $categories = SchemeCategory::where('is_active', true)
            ->withCount(['schemes' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
        $query = Scheme::with('category')->where('is_active', true)->orderBy('sort_order')->orderBy('title');
        if (request()->filled('category')) {
            $query->where('scheme_category_id', request('category'));
        }
        $schemes = $query->get();
        return view('pages.scheme', compact('categories', 'schemes'));
    }

    public function schemeShow(string $slug): View|Response
    {
        $scheme = Scheme::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $relatedSchemes = Scheme::where('is_active', true)->where('id', '!=', $scheme->id)
            ->where('scheme_category_id', $scheme->scheme_category_id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();
        $categories = SchemeCategory::where('is_active', true)
            ->withCount(['schemes' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
        return view('pages.scheme-detail', compact('scheme', 'relatedSchemes', 'categories'));
    }

    public function cropIndex(): View
    {
        $categories = CropCategory::where('is_active', true)->withCount(['crops' => fn ($q) => $q->where('is_active', true)])->orderBy('sort_order')->get();
        $query = Crop::with('category')->where('is_active', true)->orderBy('sort_order')->orderBy('title');
        if (request()->filled('category')) {
            $query->where('crop_category_id', request('category'));
        }
        $crops = $query->get();
        return view('pages.crop', compact('categories', 'crops'));
    }

    public function cropShow(string $slug): View|Response
    {
        $crop = Crop::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $relatedCrops = Crop::where('is_active', true)->where('id', '!=', $crop->id)->where('crop_category_id', $crop->crop_category_id)->orderBy('sort_order')->limit(3)->get();
        $categories = \App\Models\CropCategory::where('is_active', true)->withCount(['crops' => fn ($q) => $q->where('is_active', true)])->orderBy('sort_order')->get();
        return view('pages.crop-detail', compact('crop', 'relatedCrops', 'categories'));
    }

    public function irrigationIndex(): View
    {
        $categories = IrrigationCategory::where('is_active', true)
            ->withCount(['methods' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
        $query = IrrigationMethod::with('category')->where('is_active', true)->orderBy('sort_order')->orderBy('title');
        if (request()->filled('category')) {
            $query->where('irrigation_category_id', request('category'));
        }
        $methods = $query->get();
        return view('pages.irrigation-list', compact('categories', 'methods'));
    }

    public function irrigationShow(string $slug): View|Response
    {
        $method = IrrigationMethod::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $relatedMethods = IrrigationMethod::where('is_active', true)->where('id', '!=', $method->id)
            ->where('irrigation_category_id', $method->irrigation_category_id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();
        $categories = IrrigationCategory::where('is_active', true)
            ->withCount(['methods' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
        return view('pages.irrigation-detail', compact('method', 'relatedMethods', 'categories'));
    }

    public function blogIndex(): View
    {
        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
        $query = BlogPost::with('category')->where('is_active', true)->orderBy('published_at', 'desc')->orderBy('sort_order')->orderBy('title');
        if (request()->filled('category')) {
            $query->where('blog_category_id', request('category'));
        }
        $posts = $query->get();
        return view('pages.blog', compact('categories', 'posts'));
    }

    public function blogShow(string $slug): View|Response
    {
        $post = BlogPost::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $relatedPosts = BlogPost::where('is_active', true)->where('id', '!=', $post->id)
            ->where('blog_category_id', $post->blog_category_id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
        $recentPosts = BlogPost::where('is_active', true)->where('id', '!=', $post->id)->orderBy('published_at', 'desc')->limit(5)->get();
        return view('pages.blog-detail', compact('post', 'relatedPosts', 'categories', 'recentPosts'));
    }

    public function tryAi(): View
    {
        return view('pages.try-ai');
    }

    public function term(): View|Response
    {
        $page = Page::where('slug', 'terms')->firstOrFail();
        return view('pages.term', compact('page'));
    }

    public function privacy(): View|Response
    {
        $page = Page::where('slug', 'privacy')->firstOrFail();
        return view('pages.privacy', compact('page'));
    }
}
