<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunityPostController extends Controller
{
    public function index(Request $request): View
    {
        $query = CommunityPost::with(['user', 'crop', 'problemCategory']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $posts = $query->latest()->paginate(20);
        return view('admin.community.posts.index', compact('posts'));
    }

    public function show(CommunityPost $post): View
    {
        $post->load(['user', 'crop', 'problemCategory', 'images', 'answers.user', 'answers.attachments']);
        return view('admin.community.posts.show', compact('post'));
    }

    public function update(Request $request, CommunityPost $post): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'sometimes|in:active,hidden,deleted',
            'featured' => 'sometimes|boolean',
            'comments_locked' => 'sometimes|boolean',
        ]);
        if (isset($data['featured'])) {
            $post->featured = (bool) $data['featured'];
        }
        if (isset($data['comments_locked'])) {
            $post->comments_locked = (bool) $data['comments_locked'];
        }
        if (isset($data['status'])) {
            $post->status = $data['status'];
        }
        $post->save();
        return back()->with('success', 'Post updated.');
    }

    public function destroy(CommunityPost $post): RedirectResponse
    {
        $post->update(['status' => 'deleted']);
        return redirect()->route('admin.community.posts.index')->with('success', 'Post deleted.');
    }
}
