<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerAttachment extends Model
{
    protected $fillable = ['community_answer_id', 'path', 'type', 'original_name'];

    public function communityAnswer(): BelongsTo
    {
        return $this->belongsTo(CommunityAnswer::class, 'community_answer_id');
    }

    public function getUrlAttribute(): string
    {
        return $this->path ? asset('storage/' . $this->path) : '';
    }

    public function isPdf(): bool
    {
        return $this->type === 'pdf';
    }
}
