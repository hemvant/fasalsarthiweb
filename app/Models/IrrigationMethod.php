<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IrrigationMethod extends Model
{
    protected $fillable = [
        'irrigation_category_id', 'title', 'slug', 'excerpt', 'featured_image', 'badge_text',
        'stat1_value', 'stat1_label', 'stat2_value', 'stat2_label', 'stat3_value', 'stat3_label',
        'stat4_value', 'stat4_label', 'meta_title', 'meta_description', 'about', 'content',
        'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(IrrigationCategory::class, 'irrigation_category_id');
    }
}
