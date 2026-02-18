<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProblemCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function communityPosts(): HasMany
    {
        return $this->hasMany(CommunityPost::class, 'problem_category_id');
    }
}
