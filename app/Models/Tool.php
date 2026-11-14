<?php

namespace App\Models;

use Database\Factories\ToolFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'description',
    'icon',
    'route_name',
    'component_identifier',
    'is_featured',
    'is_popular',
    'is_active',
    'sort_order',
])]
class Tool extends Model
{
    /** @use HasFactory<ToolFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<ToolTag, $this>
     */
    public function tags(): HasMany
    {
        return $this->hasMany(ToolTag::class);
    }

    /**
     * @return HasMany<ToolFavorite, $this>
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(ToolFavorite::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tool_favorites')->withTimestamps();
    }

    /**
     * @return HasMany<RecentTool, $this>
     */
    public function recentUses(): HasMany
    {
        return $this->hasMany(RecentTool::class);
    }

    /**
     * @return HasMany<UsageLog, $this>
     */
    public function usageLogs(): HasMany
    {
        return $this->hasMany(UsageLog::class);
    }

    /**
     * @param  Builder<Tool>  $query
     * @return Builder<Tool>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
