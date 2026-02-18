<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IrrigationCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function methods(): HasMany
    {
        return $this->hasMany(IrrigationMethod::class)->orderBy('sort_order')->orderBy('title');
    }
}
