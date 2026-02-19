<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommunityPost;
use App\Models\SavedPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommunityActionController extends Controller
{
    public function likePost(Request $request, CommunityPost $post): RedirectResponse
    {
        $post = CommunityPost::where('status', 'active')->findOrFail($post->id);
        $like = $post->likes()->where('user_id', $request->user()->id)->first();
        if ($like) {
            $like->delete();
            $post->decrement('likes_count');
        } else {
            $post->likes()->create(['user_id' => $request->user()->id]);
            $post->increment('likes_count');
        }
        return back();
    }

    public function savePost(Request $request, CommunityPost $post): RedirectResponse
    {
        $post = CommunityPost::where('status', 'active')->findOrFail($post->id);
        $exists = SavedPost::where('user_id', $request->user()->id)->where('community_post_id', $post->id)->exists();
        if (!$exists) {
            SavedPost::create(['user_id' => $request->user()->id, 'community_post_id' => $post->id]);
        }
        return back();
    }

    public function unsavePost(Request $request, CommunityPost $post): RedirectResponse
    {
        SavedPost::where('user_id', $request->user()->id)->where('community_post_id', $post->id)->delete();
        return back();
    }

    public function storeComment(Request $request, CommunityPost $post): RedirectResponse
    {
        $request->validate(['body' => 'required|string|max:2000']);
        $post = CommunityPost::where('status', 'active')->findOrFail($post->id);
        if ($post->comments_locked) {
            return back()->with('error', 'Comments are locked.');
        }
        Comment::create([
            'commentable_type' => \App\Models\CommunityPost::class,
            'commentable_id' => $post->id,
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);
        $post->increment('comments_count');
        return back()->with('success', 'Comment added.');
    }
}
