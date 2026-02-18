<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crop extends Model
{
    protected $fillable = [
        'crop_category_id', 'title', 'slug', 'excerpt', 'featured_image',
        'season', 'duration', 'badge_text',
        'stat_yield', 'stat_yield_label', 'stat_profit', 'stat_profit_label',
        'stat_temperature', 'stat_temperature_label', 'stat_rainfall', 'stat_rainfall_label',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
        'about', 'suitable_regions', 'soil_requirements', 'varieties',
        'growing_guide', 'growth_stages', 'pest_management', 'harvesting_guide',
        'profit_analysis', 'government_support',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'varieties' => 'array',
        'growth_stages' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CropCategory::class, 'crop_category_id');
    }
}
