<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IrrigationCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IrrigationCategoryController extends Controller
{
    public function index(): View
    {
        $categories = IrrigationCategory::withCount('methods')->orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.irrigation-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.irrigation-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:irrigation_categories,slug',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        IrrigationCategory::create($data);
        return redirect()->route('admin.irrigation-categories.index')->with('success', 'Category created.');
    }

    public function edit(IrrigationCategory $irrigationCategory): View
    {
        return view('admin.irrigation-categories.edit', ['category' => $irrigationCategory]);
    }

    public function update(Request $request, IrrigationCategory $irrigationCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:irrigation_categories,slug,' . $irrigationCategory->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $irrigationCategory->update($data);
        return redirect()->route('admin.irrigation-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(IrrigationCategory $irrigationCategory): RedirectResponse
    {
        if ($irrigationCategory->methods()->exists()) {
            return back()->with('error', 'Cannot delete category that has irrigation methods. Remove or reassign them first.');
        }
        $irrigationCategory->delete();
        return redirect()->route('admin.irrigation-categories.index')->with('success', 'Category deleted.');
    }
}
