<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommunityAnswer;
use App\Models\CommunityPost;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Report;
use App\Models\SavedPost;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityActionController extends Controller
{
    /** Like or unlike a post. */
    public function likePost(Request $request, int $id): JsonResponse
    {
        $post = CommunityPost::where('status', 'active')->findOrFail($id);
        $like = $post->likes()->where('user_id', $request->user()->id)->first();
        if ($like) {
            $like->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $request->user()->id]);
            $post->increment('likes_count');
            $liked = true;
        }
        return response()->json(['liked' => $liked, 'likes_count' => $post->fresh()->likes_count]);
    }

    /** Like or unlike an answer. */
    public function likeAnswer(Request $request, int $id): JsonResponse
    {
        $answer = CommunityAnswer::findOrFail($id);
        $like = $answer->likes()->where('user_id', $request->user()->id)->first();
        if ($like) {
            $like->delete();
            $answer->decrement('likes_count');
            $liked = false;
        } else {
            $answer->likes()->create(['user_id' => $request->user()->id]);
            $answer->increment('likes_count');
            $liked = true;
        }
        return response()->json(['liked' => $liked, 'likes_count' => $answer->fresh()->likes_count]);
    }

    /** Add comment (on post or answer). Optional parent_id for reply. */
    public function storeComment(Request $request): JsonResponse
    {
        $request->validate([
            'commentable_type' => 'required|in:App\Models\CommunityPost,App\Models\CommunityAnswer',
            'commentable_id' => 'required|integer',
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $commentable = $request->commentable_type === 'App\Models\CommunityPost'
            ? CommunityPost::where('status', 'active')->findOrFail($request->commentable_id)
            : CommunityAnswer::findOrFail($request->commentable_id);

        if ($commentable instanceof CommunityPost && $commentable->comments_locked) {
            return response()->json(['message' => 'Comments are locked.'], 403);
        }

        $comment = Comment::create([
            'commentable_type' => $request->commentable_type,
            'commentable_id' => $request->commentable_id,
            'user_id' => $request->user()->id,
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        $commentable->increment('comments_count');
        if ($commentable instanceof CommunityAnswer) {
            $commentable->communityPost->increment('comments_count');
        }

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'user_name' => $request->user()->name,
                'body' => $comment->body,
                'created_at' => $comment->created_at->toIso8601String(),
            ],
        ], 201);
    }

    /** Follow or unfollow a user. */
    public function follow(Request $request, int $userId): JsonResponse
    {
        $target = User::findOrFail($userId);
        if ($target->id === $request->user()->id) {
            return response()->json(['message' => 'Cannot follow yourself.'], 422);
        }
        $follow = Follow::where('follower_id', $request->user()->id)->where('following_id', $target->id)->first();
        if ($follow) {
            $follow->delete();
            $following = false;
        } else {
            Follow::create(['follower_id' => $request->user()->id, 'following_id' => $target->id]);
            $following = true;
        }
        return response()->json(['following' => $following]);
    }

    /** Report a post or answer. */
    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'reportable_type' => 'required|in:App\Models\CommunityPost,App\Models\CommunityAnswer',
            'reportable_id' => 'required|integer',
            'reason' => 'nullable|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        $reportable = $request->reportable_type === 'App\Models\CommunityPost'
            ? CommunityPost::findOrFail($request->reportable_id)
            : CommunityAnswer::findOrFail($request->reportable_id);

        $exists = Report::where('reportable_type', $request->reportable_type)
            ->where('reportable_id', $request->reportable_id)
            ->where('user_id', $request->user()->id)
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Already reported.'], 422);
        }

        Report::create([
            'reportable_type' => $request->reportable_type,
            'reportable_id' => $request->reportable_id,
            'user_id' => $request->user()->id,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        if ($reportable instanceof CommunityPost) {
            $reportable->increment('report_count');
        }

        return response()->json(['message' => 'Report submitted.'], 201);
    }

    /** Save (bookmark) a post. */
    public function savePost(Request $request, int $id): JsonResponse
    {
        $post = CommunityPost::where('status', 'active')->findOrFail($id);
        $exists = SavedPost::where('user_id', $request->user()->id)->where('community_post_id', $post->id)->exists();
        if ($exists) {
            SavedPost::where('user_id', $request->user()->id)->where('community_post_id', $post->id)->delete();
            return response()->json(['saved' => false]);
        }
        SavedPost::create(['user_id' => $request->user()->id, 'community_post_id' => $post->id]);
        return response()->json(['saved' => true]);
    }

    /** Unsave (remove bookmark) a post. */
    public function unsavePost(Request $request, int $id): JsonResponse
    {
        $post = CommunityPost::where('status', 'active')->findOrFail($id);
        SavedPost::where('user_id', $request->user()->id)->where('community_post_id', $post->id)->delete();
        return response()->json(['saved' => false]);
    }
}
