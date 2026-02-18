<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\PostImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CommunityPostController extends Controller
{
    /**
     * Feed: latest or trending. Filter by crop_id, problem_category_id optional.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'filter' => 'nullable|in:latest,trending',
            'crop_id' => 'nullable|exists:crops,id',
            'problem_category_id' => 'nullable|exists:problem_categories,id',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $query = CommunityPost::with(['user:id,name', 'crop:id,title', 'problemCategory:id,name,slug', 'images'])
            ->where('status', 'active');

        if ($request->crop_id) {
            $query->where('crop_id', $request->crop_id);
        }
        if ($request->problem_category_id) {
            $query->where('problem_category_id', $request->problem_category_id);
        }

        if (($request->filter ?? 'latest') === 'trending') {
            $query->orderByDesc('likes_count')->orderByDesc('comments_count')->orderByDesc('created_at');
        } else {
            $query->orderByDesc('created_at');
        }

        $perPage = $request->input('per_page', 15);
        $posts = $query->paginate($perPage);

        $items = $posts->getCollection()->map(fn ($post) => $this->postResource($post, $request->user()));
        $posts->setCollection($items);

        return response()->json($posts);
    }

    /**
     * Create post: min 20 chars, up to 3 images, crop_id, problem_category_id.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'body' => 'required|string|min:20|max:5000',
            'crop_id' => 'nullable|exists:crops,id',
            'problem_category_id' => 'required|exists:problem_categories,id',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:5120',
        ]);

        if ($request->user()->isBanned()) {
            return response()->json(['message' => 'Account is suspended or banned.'], 403);
        }

        $post = DB::transaction(function () use ($request) {
            $post = CommunityPost::create([
                'user_id' => $request->user()->id,
                'crop_id' => $request->crop_id,
                'problem_category_id' => $request->problem_category_id,
                'body' => $request->body,
                'status' => 'active',
            ]);
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('community/posts', 'public');
                    PostImage::create([
                        'community_post_id' => $post->id,
                        'path' => $path,
                        'sort_order' => $i,
                    ]);
                }
            }
            return $post->load(['user:id,name', 'crop:id,title', 'problemCategory:id,name,slug', 'images']);
        });

        return response()->json(['post' => $this->postResource($post, $request->user())], 201);
    }

    /**
     * Post detail: full question, image gallery, answers (experts pinned first), comments under answers.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $post = CommunityPost::with([
            'user:id,name',
            'crop:id,title',
            'problemCategory:id,name,slug',
            'images',
            'answers' => fn ($q) => $q->with(['user:id,name', 'attachments'])->orderByDesc('is_pinned')->orderByDesc('is_best_answer')->orderByDesc('created_at'),
            'answers.user.expertProfile:id,user_id,verified,status',
        ])->where('status', 'active')->findOrFail($id);

        foreach ($post->answers as $answer) {
            $answer->setRelation('comments', $answer->comments()->with('user:id,name', 'replies.user:id,name')->get());
            $answer->setAttribute('is_expert', $answer->isFromExpert());
        }

        $post->setRelation('comments', $post->comments()->with('user:id,name', 'replies.user:id,name')->get());

        return response()->json([
            'post' => $this->postDetailResource($post, $request->user()),
        ]);
    }

    private function postResource(CommunityPost $post, $user): array
    {
        $liked = $user ? $post->likes()->where('user_id', $user->id)->exists() : false;
        return [
            'id' => $post->id,
            'farmer_name' => $post->user?->name,
            'crop' => $post->crop ? ['id' => $post->crop->id, 'title' => $post->crop->title] : null,
            'problem_type' => $post->problemCategory ? ['id' => $post->problemCategory->id, 'name' => $post->problemCategory->name] : null,
            'body' => $post->body,
            'images' => $post->images->map(fn ($i) => asset('storage/' . $i->path))->values()->all(),
            'likes_count' => $post->likes_count,
            'comments_count' => $post->comments_count,
            'expert_replied' => $post->expert_replied,
            'created_at' => $post->created_at->toIso8601String(),
            'liked' => $liked,
        ];
    }

    private function postDetailResource(CommunityPost $post, $user): array
    {
        $liked = $user ? $post->likes()->where('user_id', $user->id)->exists() : false;
        $answers = $post->answers->map(function ($a) use ($user) {
            $answerLiked = $user ? $a->likes()->where('user_id', $user->id)->exists() : false;
            return [
                'id' => $a->id,
                'body' => $a->body,
                'user_name' => $a->user?->name,
                'is_expert' => $a->isFromExpert(),
                'verified' => $a->user?->expertProfile?->verified ?? false,
                'is_pinned' => $a->is_pinned,
                'is_best_answer' => $a->is_best_answer,
                'likes_count' => $a->likes_count,
                'attachments' => $a->attachments->map(fn ($at) => ['url' => $at->url, 'type' => $at->type])->all(),
                'comments' => $this->commentsTree($a->comments),
                'created_at' => $a->created_at->toIso8601String(),
                'liked' => $answerLiked,
            ];
        });
        return [
            'id' => $post->id,
            'farmer_name' => $post->user?->name,
            'crop' => $post->crop ? ['id' => $post->crop->id, 'title' => $post->crop->title] : null,
            'problem_type' => $post->problemCategory ? ['id' => $post->problemCategory->id, 'name' => $post->problemCategory->name] : null,
            'body' => $post->body,
            'images' => $post->images->map(fn ($i) => asset('storage/' . $i->path))->values()->all(),
            'likes_count' => $post->likes_count,
            'comments_count' => $post->comments_count,
            'comments_locked' => $post->comments_locked,
            'expert_replied' => $post->expert_replied,
            'is_solved' => $post->is_solved,
            'created_at' => $post->created_at->toIso8601String(),
            'liked' => $liked,
            'answers' => $answers,
            'comments' => $this->commentsTree($post->comments),
        ];
    }

    private function commentsTree($comments): array
    {
        return $comments->map(function ($c) {
            $arr = [
                'id' => $c->id,
                'user_name' => $c->user?->name,
                'body' => $c->body,
                'created_at' => $c->created_at->toIso8601String(),
            ];
            if ($c->replies->isNotEmpty()) {
                $arr['replies'] = $this->commentsTree($c->replies);
            }
            return $arr;
        })->all();
    }
}
