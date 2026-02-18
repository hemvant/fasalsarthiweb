<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\CropCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CropController extends Controller
{
    public function index(Request $request): View
    {
        $query = Crop::with('category')->orderBy('sort_order')->orderBy('title');
        if ($request->filled('category')) {
            $query->where('crop_category_id', $request->category);
        }
        $crops = $query->paginate(15);
        $categories = CropCategory::orderBy('sort_order')->get();
        return view('admin.crops.index', compact('crops', 'categories'));
    }

    public function create(): View
    {
        $categories = CropCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.crops.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateCrop($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['varieties'] = $this->parseVarieties($request);
        $data['growth_stages'] = $this->parseGrowthStages($request);
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('crops', 'public');
        }
        Crop::create($data);
        return redirect()->route('admin.crops.index')->with('success', 'Crop created.');
    }

    public function edit(Crop $crop): View
    {
        $categories = CropCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.crops.edit', compact('crop', 'categories'));
    }

    public function update(Request $request, Crop $crop): RedirectResponse
    {
        $data = $this->validateCrop($request, $crop->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['varieties'] = $this->parseVarieties($request);
        $data['growth_stages'] = $this->parseGrowthStages($request);
        if ($request->hasFile('featured_image')) {
            if ($crop->featured_image) {
                Storage::disk('public')->delete($crop->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('crops', 'public');
        }
        if ($request->has('remove_featured_image') && $request->remove_featured_image) {
            if ($crop->featured_image) {
                Storage::disk('public')->delete($crop->featured_image);
            }
            $data['featured_image'] = null;
        }
        $crop->update($data);
        return redirect()->route('admin.crops.index')->with('success', 'Crop updated.');
    }

    public function destroy(Crop $crop): RedirectResponse
    {
        if ($crop->featured_image) {
            Storage::disk('public')->delete($crop->featured_image);
        }
        $crop->delete();
        return redirect()->route('admin.crops.index')->with('success', 'Crop deleted.');
    }

    private function validateCrop(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:255|unique:crops,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }
        return $request->validate([
            'crop_category_id' => 'required|exists:crop_categories,id',
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:4096',
            'season' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'badge_text' => 'nullable|string|max:100',
            'stat_yield' => 'nullable|string|max:50',
            'stat_yield_label' => 'nullable|string|max:100',
            'stat_profit' => 'nullable|string|max:50',
            'stat_profit_label' => 'nullable|string|max:100',
            'stat_temperature' => 'nullable|string|max:50',
            'stat_temperature_label' => 'nullable|string|max:100',
            'stat_rainfall' => 'nullable|string|max:50',
            'stat_rainfall_label' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'about' => 'nullable|string',
            'suitable_regions' => 'nullable|string',
            'soil_requirements' => 'nullable|string',
            'growing_guide' => 'nullable|string',
            'pest_management' => 'nullable|string',
            'harvesting_guide' => 'nullable|string',
            'profit_analysis' => 'nullable|string',
            'government_support' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    private function parseVarieties(Request $request): array
    {
        $names = $request->input('variety_name', []);
        $durations = $request->input('variety_duration', []);
        $yields = $request->input('variety_yield', []);
        $features = $request->input('variety_features', []);
        $out = [];
        foreach ($names as $i => $name) {
            if (trim((string) $name) !== '') {
                $out[] = [
                    'name' => $name,
                    'duration' => $durations[$i] ?? '',
                    'yield' => $yields[$i] ?? '',
                    'features' => $features[$i] ?? '',
                ];
            }
        }
        return $out;
    }

    private function parseGrowthStages(Request $request): array
    {
        $titles = $request->input('stage_title', []);
        $durations = $request->input('stage_duration', []);
        $descriptions = $request->input('stage_description', []);
        $icons = $request->input('stage_icon', []);
        $out = [];
        foreach ($titles as $i => $title) {
            if (trim((string) $title) !== '') {
                $out[] = [
                    'title' => $title,
                    'duration' => $durations[$i] ?? '',
                    'description' => $descriptions[$i] ?? '',
                    'icon' => $icons[$i] ?? 'fas fa-seedling',
                ];
            }
        }
        return $out;
    }
}
