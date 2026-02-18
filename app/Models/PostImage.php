<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    protected $fillable = ['community_post_id', 'path', 'sort_order'];

    public function communityPost(): BelongsTo
    {
        return $this->belongsTo(CommunityPost::class, 'community_post_id');
    }

    public function getUrlAttribute(): string
    {
        return $this->path ? asset('storage/' . $this->path) : '';
    }
}
