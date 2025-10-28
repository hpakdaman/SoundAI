<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    protected $table = 'music_genres';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'prompt_keywords',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the compositions for this genre.
     */
    public function compositions(): HasMany
    {
        return $this->hasMany(Composition::class, 'genre_id');
    }

    /**
     * Get the prompt keywords or fallback to name.
     */
    public function getKeywordsAttribute(): string
    {
        return $this->prompt_keywords ?? $this->name;
    }

    /**
     * Scope to get only active genres.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
