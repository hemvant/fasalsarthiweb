<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpertArticleCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(ExpertArticle::class, 'expert_article_category_id');
    }
}
