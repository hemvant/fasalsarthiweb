<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserCrop;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'mobile',
        'is_banned',
        'suspended_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'suspended_until' => 'datetime',
        ];
    }

    public function crops(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserCrop::class, 'user_id');
    }

    public function expertProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ExpertProfile::class);
    }

    public function communityPosts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityPost::class, 'user_id');
    }

    public function communityAnswers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityAnswer::class, 'user_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function followers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    public function following(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    public function expertArticles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExpertArticle::class, 'user_id');
    }

    public function isExpert(): bool
    {
        $profile = $this->expertProfile;
        return $profile && $profile->isApproved() && !$profile->isSuspended();
    }

    public function isBanned(): bool
    {
        return $this->is_banned || ($this->suspended_until && $this->suspended_until->isFuture());
    }
}
