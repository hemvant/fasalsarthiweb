<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';
    const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'message',
        'status', 'admin_notes', 'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_READ => 'Read',
            self::STATUS_REPLIED => 'Replied',
            self::STATUS_ARCHIVED => 'Archived',
        ];
    }
}
