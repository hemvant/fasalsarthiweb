<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function index(): View
    {
        $features = Feature::orderBy('sort_order')->orderBy('title')->paginate(15);
        return view('admin.features.index', compact('features'));
    }

    public function create(): View
    {
        return view('admin.features.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateFeature($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('features', 'public');
        }
        Feature::create($data);
        return redirect()->route('admin.features.index')->with('success', 'Feature created.');
    }

    public function edit(Feature $feature): View
    {
        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $data = $this->validateFeature($request, $feature->id);
        if (! $data['slug']) {
            $data['slug'] = Str::slug($data['title']);
        }
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('featured_image')) {
            if ($feature->featured_image) {
                Storage::disk('public')->delete($feature->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('features', 'public');
        }
        if ($request->boolean('remove_featured_image') && $feature->featured_image) {
            Storage::disk('public')->delete($feature->featured_image);
            $data['featured_image'] = null;
        }
        $feature->update($data);
        return redirect()->route('admin.features.index')->with('success', 'Feature updated.');
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        if ($feature->featured_image) {
            Storage::disk('public')->delete($feature->featured_image);
        }
        $feature->delete();
        return redirect()->route('admin.features.index')->with('success', 'Feature deleted.');
    }

    private function validateFeature(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:features,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'icon_color' => 'nullable|string|in:green,blue,orange,purple,teal',
            'featured_image' => 'nullable|image|max:2048',
            'remove_featured_image' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);
    }
}
