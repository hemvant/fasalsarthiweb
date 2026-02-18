<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IrrigationMethod;
use App\Models\IrrigationCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class IrrigationMethodController extends Controller
{
    public function index(Request $request): View
    {
        $query = IrrigationMethod::with('category')->orderBy('sort_order')->orderBy('title');
        if ($request->filled('category')) {
            $query->where('irrigation_category_id', $request->category);
        }
        $methods = $query->paginate(15);
        $categories = IrrigationCategory::orderBy('sort_order')->get();
        return view('admin.irrigation-methods.index', compact('methods', 'categories'));
    }

    public function create(): View
    {
        $categories = IrrigationCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.irrigation-methods.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateMethod($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('irrigation', 'public');
        }
        IrrigationMethod::create($data);
        return redirect()->route('admin.irrigation-methods.index')->with('success', 'Irrigation method created.');
    }

    public function edit(IrrigationMethod $irrigationMethod): View
    {
        $categories = IrrigationCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.irrigation-methods.edit', ['method' => $irrigationMethod, 'categories' => $categories]);
    }

    public function update(Request $request, IrrigationMethod $irrigationMethod): RedirectResponse
    {
        $data = $this->validateMethod($request, $irrigationMethod->id);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('featured_image')) {
            if ($irrigationMethod->featured_image) {
                Storage::disk('public')->delete($irrigationMethod->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('irrigation', 'public');
        }
        if ($request->has('remove_featured_image') && $request->remove_featured_image) {
            if ($irrigationMethod->featured_image) {
                Storage::disk('public')->delete($irrigationMethod->featured_image);
            }
            $data['featured_image'] = null;
        }
        $irrigationMethod->update($data);
        return redirect()->route('admin.irrigation-methods.index')->with('success', 'Irrigation method updated.');
    }

    public function destroy(IrrigationMethod $irrigationMethod): RedirectResponse
    {
        if ($irrigationMethod->featured_image) {
            Storage::disk('public')->delete($irrigationMethod->featured_image);
        }
        $irrigationMethod->delete();
        return redirect()->route('admin.irrigation-methods.index')->with('success', 'Irrigation method deleted.');
    }

    private function validateMethod(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:255|unique:irrigation_methods,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }
        return $request->validate([
            'irrigation_category_id' => 'required|exists:irrigation_categories,id',
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:4096',
            'badge_text' => 'nullable|string|max:100',
            'stat1_value' => 'nullable|string|max:100',
            'stat1_label' => 'nullable|string|max:100',
            'stat2_value' => 'nullable|string|max:100',
            'stat2_label' => 'nullable|string|max:100',
            'stat3_value' => 'nullable|string|max:100',
            'stat3_label' => 'nullable|string|max:100',
            'stat4_value' => 'nullable|string|max:100',
            'stat4_label' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'about' => 'nullable|string',
            'content' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
