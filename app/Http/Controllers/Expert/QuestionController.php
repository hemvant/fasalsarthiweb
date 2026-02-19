<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\CommunityAnswer;
use App\Models\CommunityPost;
use App\Models\Crop;
use App\Models\ProblemCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $query = CommunityPost::with(['user', 'crop', 'problemCategory', 'images'])
            ->where('status', 'active');

        if ($request->filled('crop_id')) {
            $query->where('crop_id', $request->crop_id);
        }
        if ($request->filled('problem_category_id')) {
            $query->where('problem_category_id', $request->problem_category_id);
        }
        if ($request->filled('unsolved') && $request->unsolved) {
            $query->where('is_solved', false);
        }
        $query->latest();

        $questions = $query->paginate(15)->withQueryString();
        $crops = Crop::where('is_active', true)->orderBy('title')->get(['id', 'title']);
        $categories = ProblemCategory::where('is_active', true)->orderBy('sort_order')->get(['id', 'name']);

        $user = $request->user();
        $postIds = $questions->pluck('id');
        $likedIds = $user ? \App\Models\Like::where('likeable_type', CommunityPost::class)
            ->whereIn('likeable_id', $postIds)
            ->where('user_id', $user->id)
            ->pluck('likeable_id')
            ->flip()
            ->all() : [];
        $savedIds = $user ? $user->savedPosts()->whereIn('community_posts.id', $postIds)->pluck('community_posts.id')->flip()->all() : [];

        return view('expert.questions.index', compact('questions', 'crops', 'categories', 'likedIds', 'savedIds'));
    }

    public function show(Request $request, CommunityPost $post): View
    {
        $post->load(['user', 'crop', 'problemCategory', 'images', 'answers' => fn ($q) => $q->with(['user.expertProfile', 'attachments'])->orderByDesc('is_pinned')->orderByDesc('is_best_answer')->latest(), 'comments' => fn ($q) => $q->with('user')->orderBy('created_at')]);
        $user = $request->user();
        $liked = $user ? $post->likes()->where('user_id', $user->id)->exists() : false;
        $saved = $user ? $user->savedPosts()->where('community_post_id', $post->id)->exists() : false;
        return view('expert.questions.show', compact('post', 'liked', 'saved'));
    }

    public function storeAnswer(Request $request, CommunityPost $post): RedirectResponse
    {
        $request->validate([
            'body' => 'required|string|min:20',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $answer = CommunityAnswer::create([
            'community_post_id' => $post->id,
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('answers', 'public');
                $ext = strtolower($file->getClientOriginalExtension());
                $answer->attachments()->create([
                    'path' => $path,
                    'type' => $ext === 'pdf' ? 'pdf' : 'image',
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        $profile = $request->user()->expertProfile;
        if ($profile) {
            $profile->increment('total_answers');
        }
        $post->update(['expert_replied' => true]);

        return redirect()->route('expert.questions.show', $post)->with('success', 'Answer submitted.');
    }

    public function markSolved(CommunityPost $post): RedirectResponse
    {
        $post->update(['is_solved' => true]);
        return back()->with('success', 'Question marked as solved.');
    }
}
