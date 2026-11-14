<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @return HasMany<ToolFavorite, $this>
     */
    public function toolFavorites(): HasMany
    {
        return $this->hasMany(ToolFavorite::class);
    }

    /**
     * @return BelongsToMany<Tool, $this>
     */
    public function favoriteTools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class, 'tool_favorites')->withTimestamps();
    }

    /**
     * @return HasMany<RecentTool, $this>
     */
    public function recentTools(): HasMany
    {
        return $this->hasMany(RecentTool::class);
    }

    /**
     * @return HasMany<Subscription, $this>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * @return HasMany<UsageLog, $this>
     */
    public function usageLogs(): HasMany
    {
        return $this->hasMany(UsageLog::class);
    }

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
        ];
    }
}
