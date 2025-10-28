<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instrument extends Model
{
    protected $table = 'music_instruments';

    protected $fillable = [
        'name',
        'slug',
        'category',
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
     * Get the compositions that use this instrument.
     */
    public function compositions(): BelongsToMany
    {
        return $this->belongsToMany(Composition::class, 'music_composition_instruments', 'instrument_id', 'composition_id')
            ->withTimestamps();
    }

    /**
     * Get the prompt keywords or fallback to name.
     */
    public function getKeywordsAttribute(): string
    {
        return $this->prompt_keywords ?? $this->name;
    }

    /**
     * Scope to get only active instruments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
