<?php

namespace App\Models\Music;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Composition extends Model
{
    use SoftDeletes;

    protected $table = 'music_compositions';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'slug',
        'genre_id',
        'custom_genre',
        'custom_vibe',
        'custom_instruments',
        'tempo',
        'duration',
        'key_signature',
        'time_signature',
        'style_keywords',
        'full_prompt',
        'prompt_pattern_used',
        'generation_parameters',
        'audio_file_path',
        'waveform_data',
        'file_size',
        'file_format',
        'status',
        'error_message',
        'processing_time',
        'cost_estimate',
        'privacy',
        'featured',
        'play_count',
        'download_count',
        'like_count',
    ];

    protected $casts = [
        'custom_instruments' => 'array',
        'generation_parameters' => 'array',
        'waveform_data' => 'array',
        'file_size' => 'integer',
        'processing_time' => 'integer',
        'cost_estimate' => 'decimal:4',
        'featured' => 'boolean',
        'play_count' => 'integer',
        'download_count' => 'integer',
        'like_count' => 'integer',
    ];

    /**
     * Get the user that owns the composition.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the genre (if predefined was selected).
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the vibes for this composition.
     */
    public function vibes(): BelongsToMany
    {
        return $this->belongsToMany(Vibe::class, 'music_composition_vibes', 'composition_id', 'vibe_id')
            ->withTimestamps();
    }

    /**
     * Get the instruments for this composition.
     */
    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'music_composition_instruments', 'composition_id', 'instrument_id')
            ->withTimestamps();
    }

    /**
     * Get the generation history for this composition.
     */
    public function generationHistory(): HasMany
    {
        return $this->hasMany(GenerationHistory::class, 'composition_id');
    }

    /**
     * Get the effective genre name (predefined or custom).
     */
    public function getEffectiveGenreAttribute(): ?string
    {
        return $this->genre?->name ?? $this->custom_genre;
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get completed compositions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get public compositions.
     */
    public function scopePublic($query)
    {
        return $query->where('privacy', 'public');
    }

    /**
     * Scope to get featured compositions.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope to get compositions by user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
