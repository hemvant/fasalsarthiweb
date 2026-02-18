<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\ExpertArticle;
use App\Models\ExpertArticleCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = ExpertArticle::where('user_id', $request->user()->id)
            ->with('category')
            ->latest()
            ->paginate(15);
        return view('expert.articles.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = ExpertArticleCategory::orderBy('name')->get();
        return view('expert.articles.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'expert_article_category_id' => 'nullable|exists:expert_article_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'publish' => 'boolean',
        ]);
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['status'] = $request->boolean('publish') ? 'published' : 'draft';
        $data['approved'] = false;
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }
        ExpertArticle::create($data);
        return redirect()->route('expert.articles.index')->with('success', 'Article saved.');
    }

    public function edit(ExpertArticle $article): View|RedirectResponse
    {
        if ($article->user_id !== request()->user()->id) {
            abort(403);
        }
        $categories = ExpertArticleCategory::orderBy('name')->get();
        return view('expert.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, ExpertArticle $article): RedirectResponse
    {
        if ($article->user_id !== $request->user()->id) {
            abort(403);
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'expert_article_category_id' => 'nullable|exists:expert_article_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'publish' => 'boolean',
        ]);
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }
        if ($request->boolean('publish') && $article->status !== 'published') {
            $data['status'] = 'published';
            $data['approved'] = false;
        }
        $article->update($data);
        return redirect()->route('expert.articles.index')->with('success', 'Article updated.');
    }
}
