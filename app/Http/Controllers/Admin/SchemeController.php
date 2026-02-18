<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use App\Models\SchemeCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SchemeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Scheme::with('category')->orderBy('sort_order')->orderBy('title');
        if ($request->filled('category')) {
            $query->where('scheme_category_id', $request->category);
        }
        $schemes = $query->paginate(15);
        $categories = SchemeCategory::orderBy('sort_order')->get();
        return view('admin.schemes.index', compact('schemes', 'categories'));
    }

    public function create(): View
    {
        $categories = SchemeCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.schemes.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateScheme($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['benefit_tags'] = $this->parseTags($request->input('benefit_tags'));
        $data['resources'] = $this->parseResources($request);
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('schemes', 'public');
        }
        Scheme::create($data);
        return redirect()->route('admin.schemes.index')->with('success', 'Scheme created.');
    }

    public function edit(Scheme $scheme): View
    {
        $categories = SchemeCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.schemes.edit', compact('scheme', 'categories'));
    }

    public function update(Request $request, Scheme $scheme): RedirectResponse
    {
        $data = $this->validateScheme($request, $scheme->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['benefit_tags'] = $this->parseTags($request->input('benefit_tags'));
        $data['resources'] = $this->parseResources($request);
        if ($request->hasFile('featured_image')) {
            if ($scheme->featured_image) {
                Storage::disk('public')->delete($scheme->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('schemes', 'public');
        }
        if ($request->has('remove_featured_image') && $request->remove_featured_image) {
            if ($scheme->featured_image) {
                Storage::disk('public')->delete($scheme->featured_image);
            }
            $data['featured_image'] = null;
        }
        $scheme->update($data);
        return redirect()->route('admin.schemes.index')->with('success', 'Scheme updated.');
    }

    public function destroy(Scheme $scheme): RedirectResponse
    {
        if ($scheme->featured_image) {
            Storage::disk('public')->delete($scheme->featured_image);
        }
        $scheme->delete();
        return redirect()->route('admin.schemes.index')->with('success', 'Scheme deleted.');
    }

    private function validateScheme(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:255|unique:schemes,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }
        return $request->validate([
            'scheme_category_id' => 'required|exists:scheme_categories,id',
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:4096',
            'badge_text' => 'nullable|string|max:100',
            'ministry' => 'nullable|string|max:255',
            'deadline' => 'nullable|string|max:255',
            'stat1_value' => 'nullable|string|max:100',
            'stat1_label' => 'nullable|string|max:100',
            'stat2_value' => 'nullable|string|max:100',
            'stat2_label' => 'nullable|string|max:100',
            'stat3_value' => 'nullable|string|max:100',
            'stat3_label' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'about' => 'nullable|string',
            'benefits' => 'nullable|string',
            'eligibility_criteria' => 'nullable|string',
            'premium_rates' => 'nullable|string',
            'application_process' => 'nullable|string',
            'documents_required' => 'nullable|string',
            'covered_crops' => 'nullable|string',
            'claim_process' => 'nullable|string',
            'apply_cta_title' => 'nullable|string|max:255',
            'apply_cta_text' => 'nullable|string',
            'apply_cta_button_text' => 'nullable|string|max:255',
            'apply_cta_button_url' => 'nullable|string|max:500',
            'helpline_phone' => 'nullable|string|max:100',
            'helpline_email' => 'nullable|string|max:255',
            'important_dates' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    private function parseTags(?string $input): array
    {
        if (empty($input)) {
            return [];
        }
        return array_filter(array_map('trim', preg_split('/[\n,]+/', $input)));
    }

    private function parseResources(Request $request): array
    {
        $titles = $request->input('resource_title', []);
        $urls = $request->input('resource_url', []);
        $out = [];
        foreach ($titles as $i => $title) {
            if (trim((string) $title) !== '') {
                $out[] = [
                    'title' => $title,
                    'url' => $urls[$i] ?? '#',
                ];
            }
        }
        return $out;
    }
}
