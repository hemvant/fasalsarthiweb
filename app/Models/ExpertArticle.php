<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpertArticle extends Model
{
    protected $fillable = [
        'user_id', 'expert_article_category_id', 'title', 'slug', 'body', 'featured_image',
        'status', 'featured', 'approved',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'approved' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpertArticleCategory::class, 'expert_article_category_id');
    }
}
