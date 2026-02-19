<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWeather extends Model
{
    protected $table = 'user_weather';

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'location_name',
        'timezone',
        'data',
        'fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'fetched_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
