<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCrop extends Model
{
    use HasFactory;

    protected $table = 'user_crops';

    protected $fillable = [
        'user_id',
        'crop_id',
        'name',
        'variety',
        'area',
        'stage',
        'health',
        'farm_name',
        'notes',
        'planted_date',
        'expected_harvest',
        'yield_estimate',
        'last_irrigation',
        'next_action',
        'water_needs',
        'nutrient_level',
        'temperature_range',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'area' => 'decimal:2',
            'planted_date' => 'date',
            'expected_harvest' => 'date',
            'water_needs' => 'integer',
            'nutrient_level' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class, 'crop_id');
    }
}
