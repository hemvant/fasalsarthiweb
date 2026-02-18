<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExpertArticleController extends Controller
{
    public function index(): View
    {
        $articles = ExpertArticle::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.community.articles.index', compact('articles'));
    }

    public function show(ExpertArticle $article): View
    {
        $article->load(['user', 'category']);
        return view('admin.community.articles.show', compact('article'));
    }

    public function approve(ExpertArticle $article): RedirectResponse
    {
        $article->update(['status' => 'published', 'approved' => true]);
        return back()->with('success', 'Article approved and published.');
    }

    public function feature(ExpertArticle $article): RedirectResponse
    {
        $article->update(['featured' => !$article->featured]);
        return back()->with('success', $article->featured ? 'Article featured.' : 'Feature removed.');
    }

    public function destroy(ExpertArticle $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('admin.community.articles.index')->with('success', 'Article deleted.');
    }
}
