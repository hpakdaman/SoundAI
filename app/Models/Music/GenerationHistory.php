<?php

namespace App\Models\Music;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenerationHistory extends Model
{
    protected $table = 'music_generation_history';

    protected $fillable = [
        'user_id',
        'composition_id',
        'full_prompt',
        'prompt_pattern_used',
        'generation_parameters',
        'status',
        'error_message',
        'api_response',
        'processing_time',
        'cost',
        'vertex_ai_job_id',
    ];

    protected $casts = [
        'generation_parameters' => 'array',
        'api_response' => 'array',
        'processing_time' => 'integer',
        'cost' => 'decimal:4',
    ];

    /**
     * Get the user that made the generation request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the composition that was generated.
     */
    public function composition(): BelongsTo
    {
        return $this->belongsTo(Composition::class);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get successful generations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get failed generations.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
