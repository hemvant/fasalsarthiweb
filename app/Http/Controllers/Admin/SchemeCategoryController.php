<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchemeCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SchemeCategoryController extends Controller
{
    public function index(): View
    {
        $categories = SchemeCategory::withCount('schemes')->orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.scheme-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.scheme-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:scheme_categories,slug',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        SchemeCategory::create($data);
        return redirect()->route('admin.scheme-categories.index')->with('success', 'Category created.');
    }

    public function edit(SchemeCategory $schemeCategory): View
    {
        return view('admin.scheme-categories.edit', ['category' => $schemeCategory]);
    }

    public function update(Request $request, SchemeCategory $schemeCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:scheme_categories,slug,' . $schemeCategory->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $schemeCategory->update($data);
        return redirect()->route('admin.scheme-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(SchemeCategory $schemeCategory): RedirectResponse
    {
        if ($schemeCategory->schemes()->exists()) {
            return back()->with('error', 'Cannot delete category that has schemes. Remove or reassign schemes first.');
        }
        $schemeCategory->delete();
        return redirect()->route('admin.scheme-categories.index')->with('success', 'Category deleted.');
    }
}
