<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchemeCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function schemes(): HasMany
    {
        return $this->hasMany(Scheme::class)->orderBy('sort_order');
    }

    public function activeSchemes(): HasMany
    {
        return $this->hasMany(Scheme::class)->where('is_active', true)->orderBy('sort_order');
    }
}
