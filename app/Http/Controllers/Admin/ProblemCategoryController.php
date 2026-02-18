<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProblemCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProblemCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ProblemCategory::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.community.problem-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.community.problem-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        ProblemCategory::create($data);
        return redirect()->route('admin.community.problem-categories.index')->with('success', 'Category created.');
    }

    public function edit(ProblemCategory $problemCategory): View
    {
        return view('admin.community.problem-categories.edit', ['category' => $problemCategory]);
    }

    public function update(Request $request, ProblemCategory $problemCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        $problemCategory->update($data);
        return redirect()->route('admin.community.problem-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(ProblemCategory $problemCategory): RedirectResponse
    {
        if ($problemCategory->communityPosts()->exists()) {
            return back()->with('error', 'Cannot delete: category has posts.');
        }
        $problemCategory->delete();
        return redirect()->route('admin.community.problem-categories.index')->with('success', 'Category deleted.');
    }
}
