<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommunityAnswer extends Model
{
    protected $table = 'community_answers';

    protected $fillable = [
        'community_post_id', 'user_id', 'body', 'is_pinned', 'is_best_answer', 'likes_count',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_best_answer' => 'boolean',
        ];
    }

    public function communityPost(): BelongsTo
    {
        return $this->belongsTo(CommunityPost::class, 'community_post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AnswerAttachment::class, 'community_answer_id');
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

    public function isFromExpert(): bool
    {
        $profile = $this->user?->expertProfile;
        return $profile && $profile->isApproved() && !$profile->isSuspended();
    }
}
