<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpertProfile extends Model
{
    protected $fillable = [
        'user_id', 'qualification', 'experience', 'specialization', 'certificate_path',
        'status', 'rating', 'total_answers', 'availability', 'verified', 'suspended_at', 'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'verified' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SUSPENDED = 'suspended';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED || $this->suspended_at !== null;
    }

    public function getCertificateUrlAttribute(): ?string
    {
        return $this->certificate_path ? asset('storage/' . $this->certificate_path) : null;
    }
}
