<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_category_id', 'title', 'slug', 'excerpt', 'featured_image',
        'author_name', 'author_bio', 'published_at', 'read_time', 'content',
        'table_of_contents', 'tags', 'meta_title', 'meta_description',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'published_at' => 'date',
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
