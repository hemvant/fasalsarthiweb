<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CropCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CropCategoryController extends Controller
{
    public function index(): View
    {
        $categories = CropCategory::withCount('crops')->orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.crop-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.crop-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:crop_categories,slug',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        CropCategory::create($data);
        return redirect()->route('admin.crop-categories.index')->with('success', 'Category created.');
    }

    public function edit(CropCategory $cropCategory): View
    {
        return view('admin.crop-categories.edit', ['category' => $cropCategory]);
    }

    public function update(Request $request, CropCategory $cropCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:crop_categories,slug,' . $cropCategory->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $cropCategory->update($data);
        return redirect()->route('admin.crop-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(CropCategory $cropCategory): RedirectResponse
    {
        if ($cropCategory->crops()->exists()) {
            return back()->with('error', 'Cannot delete category that has crops. Remove or reassign crops first.');
        }
        $cropCategory->delete();
        return redirect()->route('admin.crop-categories.index')->with('success', 'Category deleted.');
    }
}
