<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheme extends Model
{
    protected $fillable = [
        'scheme_category_id', 'title', 'slug', 'excerpt', 'featured_image', 'badge_text',
        'ministry', 'deadline',
        'stat1_value', 'stat1_label', 'stat2_value', 'stat2_label', 'stat3_value', 'stat3_label',
        'meta_title', 'meta_description',
        'about', 'benefits', 'eligibility_criteria', 'premium_rates', 'application_process',
        'documents_required', 'covered_crops', 'claim_process',
        'apply_cta_title', 'apply_cta_text', 'apply_cta_button_text', 'apply_cta_button_url',
        'helpline_phone', 'helpline_email', 'important_dates', 'benefit_tags', 'resources',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'benefit_tags' => 'array',
        'resources' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SchemeCategory::class, 'scheme_category_id');
    }
}
