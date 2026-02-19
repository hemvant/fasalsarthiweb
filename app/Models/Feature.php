<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feature extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'icon', 'icon_color',
        'featured_image', 'sort_order', 'is_active', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function iconColorClasses(): array
    {
        return [
            'green' => 'icon-green',
            'blue' => 'icon-blue',
            'orange' => 'icon-orange',
            'purple' => 'icon-purple',
            'teal' => 'icon-teal',
        ];
    }

    public function getIconClassAttribute(): string
    {
        $map = self::iconColorClasses();
        return $map[$this->icon_color] ?? 'icon-green';
    }
}
