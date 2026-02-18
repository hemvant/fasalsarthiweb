<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::with('category')->orderBy('published_at', 'desc')->orderBy('sort_order')->orderBy('title');
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }
        $posts = $query->paginate(15);
        $categories = BlogCategory::orderBy('sort_order')->get();
        return view('admin.blog-posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.blog-posts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePost($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['tags'] = $this->parseTags($request->input('tags'));
        $data['published_at'] = $request->filled('published_at') ? $request->published_at : null;
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }
        BlogPost::create($data);
        return redirect()->route('admin.blog-posts.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $blogPost): View
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.blog-posts.edit', compact('blogPost', 'categories'));
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $data = $this->validatePost($request, $blogPost->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['tags'] = $this->parseTags($request->input('tags'));
        $data['published_at'] = $request->filled('published_at') ? $request->published_at : null;
        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }
        if ($request->has('remove_featured_image') && $request->remove_featured_image) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $data['featured_image'] = null;
        }
        $blogPost->update($data);
        return redirect()->route('admin.blog-posts.index')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }
        $blogPost->delete();
        return redirect()->route('admin.blog-posts.index')->with('success', 'Post deleted.');
    }

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:255|unique:blog_posts,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }
        return $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:4096',
            'author_name' => 'nullable|string|max:255',
            'author_bio' => 'nullable|string',
            'published_at' => 'nullable|date',
            'read_time' => 'nullable|string|max:100',
            'content' => 'nullable|string',
            'table_of_contents' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
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
}
