<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CropCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function crops(): HasMany
    {
        return $this->hasMany(Crop::class)->orderBy('sort_order');
    }

    public function activeCrops(): HasMany
    {
        return $this->hasMany(Crop::class)->where('is_active', true)->orderBy('sort_order');
    }
}
