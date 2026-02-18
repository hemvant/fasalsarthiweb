<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommunityPost extends Model
{
    protected $table = 'community_posts';

    protected $fillable = [
        'user_id', 'crop_id', 'problem_category_id', 'body', 'status', 'featured',
        'report_count', 'likes_count', 'comments_count', 'expert_replied', 'comments_locked', 'is_solved',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'expert_replied' => 'boolean',
            'comments_locked' => 'boolean',
            'is_solved' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class, 'crop_id');
    }

    public function problemCategory(): BelongsTo
    {
        return $this->belongsTo(ProblemCategory::class, 'problem_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class, 'community_post_id')->orderBy('sort_order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(CommunityAnswer::class, 'community_post_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
