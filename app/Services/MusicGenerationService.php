<?php

namespace App\Services;

use App\Models\Music\Composition;
use App\Models\Music\Genre;
use App\Models\Music\GenerationHistory;
use App\Services\AI\VertexAIService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MusicGenerationService
{
    protected VertexAIService $vertexAI;

    public function __construct(VertexAIService $vertexAI)
    {
        $this->vertexAI = $vertexAI;
    }

    /**
     * Generate music composition from parameters
     *
     * @param array $parameters Generation parameters
     * @return array ['success' => bool, 'composition' => Composition|null, 'error' => string|null]
     */
    public function generate(array $parameters): array
    {
        $startTime = microtime(true);
        $history = null;

        DB::beginTransaction();

        try {
            // Create generation history record
            $history = GenerationHistory::create([
                'user_id' => $parameters['user_id'],
                'composition_id' => null, // Will update after composition is created
                'parameters_used' => $parameters,
                'status' => 'processing',
                'cost_estimate' => $this->estimateCost($parameters),
            ]);

            Log::info('🎼 Starting music generation', [
                'history_id' => $history->id,
                'user_id' => $parameters['user_id'],
            ]);

            // Build prompt from parameters
            $prompt = $this->buildPrompt($parameters);
            $negativePrompt = $this->buildNegativePrompt($parameters);

            Log::info('📝 Generated prompts', [
                'prompt' => $prompt,
                'negative_prompt' => $negativePrompt,
            ]);

            // Generate music via Vertex AI
            $result = $this->vertexAI->generateMusic(
                prompt: $prompt,
                negativePrompt: $negativePrompt,
                seed: $parameters['seed'] ?? null
            );

            if (!$result['success']) {
                throw new \Exception($result['error'] ?? 'Unknown error during generation');
            }

            // Generate filename
            $filename = $this->generateFilename($parameters);

            // Save audio file
            $filePath = $this->vertexAI->saveAudioFile($result['audio_data'], $filename);

            // Create composition record
            $composition = Composition::create([
                'user_id' => $parameters['user_id'],
                'title' => $parameters['title'] ?? $this->generateTitle($parameters),
                'description' => $parameters['description'] ?? null,
                'genre_id' => $parameters['genre_id'] ?? null,
                'style' => $parameters['style'] ?? null,
                'mood' => $parameters['mood'] ?? null,
                'tempo' => $parameters['tempo'] ?? null,
                'duration' => $parameters['duration'] ?? 30, // Default 30 seconds
                'key_signature' => $parameters['key_signature'] ?? null,
                'time_signature' => $parameters['time_signature'] ?? null,
                'audio_file_path' => $filePath,
                'ai_model_used' => 'vertex-ai-lyria-002',
                'generation_parameters' => $parameters,
                'privacy' => $parameters['privacy'] ?? 'private',
                'featured' => false,
                'play_count' => 0,
                'download_count' => 0,
                'like_count' => 0,
            ]);

            // Attach relationships
            if (!empty($parameters['vibe_ids'])) {
                $composition->vibes()->attach($parameters['vibe_ids']);
            }

            if (!empty($parameters['instrument_ids'])) {
                $composition->instruments()->attach($parameters['instrument_ids']);
            }

            // Update generation history
            $processingTime = round((microtime(true) - $startTime) * 1000); // milliseconds

            $history->update([
                'composition_id' => $composition->id,
                'status' => 'completed',
                'processing_time' => $processingTime,
                'ai_response' => $result['metadata'] ?? [],
            ]);

            DB::commit();

            Log::info('✅ Music generation completed', [
                'composition_id' => $composition->id,
                'processing_time_ms' => $processingTime,
                'file_size_mb' => $result['size_mb'],
            ]);

            return [
                'success' => true,
                'composition' => $composition->load(['genre', 'vibes', 'instruments', 'user']),
                'error' => null,
                'processing_time_ms' => $processingTime,
                'file_size_mb' => $result['size_mb'],
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Music generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Update history to failed
            if ($history) {
                $history->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'processing_time' => round((microtime(true) - $startTime) * 1000),
                ]);
            }

            return [
                'success' => false,
                'composition' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Build AI prompt from parameters
     *
     * @param array $parameters
     * @return string
     */
    protected function buildPrompt(array $parameters): string
    {
        $promptPattern = config('music_generation.prompt_patterns.' . ($parameters['prompt_pattern'] ?? 'standard'));
        $parts = [];

        // Genre keywords
        if (!empty($parameters['genre_id'])) {
            $genre = Genre::find($parameters['genre_id']);
            if ($genre) {
                $keywords = $genre->prompt_keywords ?: $genre->name;
                $parts[] = $keywords;
            }
        }

        // Style
        if (!empty($parameters['style'])) {
            $parts[] = $parameters['style'];
        }

        // Vibes
        if (!empty($parameters['vibe_ids'])) {
            $vibes = \App\Models\Music\Vibe::whereIn('id', $parameters['vibe_ids'])->get();
            foreach ($vibes as $vibe) {
                $keywords = $vibe->prompt_keywords ?: $vibe->name;
                $parts[] = $keywords;
            }
        }

        // Instruments
        if (!empty($parameters['instrument_ids'])) {
            $instruments = \App\Models\Music\Instrument::whereIn('id', $parameters['instrument_ids'])->get();
            $instrumentNames = $instruments->map(function($inst) {
                return $inst->prompt_keywords ?: $inst->name;
            })->join(', ');
            $parts[] = "featuring {$instrumentNames}";
        }

        // Tempo
        if (!empty($parameters['tempo'])) {
            $tempo = $parameters['tempo'];
            if ($tempo < 80) {
                $parts[] = 'slow tempo';
            } elseif ($tempo < 120) {
                $parts[] = 'moderate tempo';
            } else {
                $parts[] = 'fast tempo';
            }
            $parts[] = "{$tempo} BPM";
        }

        // Key signature
        if (!empty($parameters['key_signature'])) {
            $parts[] = "in {$parameters['key_signature']}";
        }

        // Time signature
        if (!empty($parameters['time_signature'])) {
            $parts[] = "{$parameters['time_signature']} time";
        }

        // Mood
        if (!empty($parameters['mood'])) {
            $parts[] = "{$parameters['mood']} mood";
        }

        // Custom description
        if (!empty($parameters['description'])) {
            $parts[] = $parameters['description'];
        }

        // Build final prompt using pattern
        $prompt = str_replace(
            ['{parts}', '{style}', '{genre}', '{mood}'],
            [implode(', ', $parts), $parameters['style'] ?? '', $parameters['genre_name'] ?? '', $parameters['mood'] ?? ''],
            $promptPattern
        );

        return trim($prompt);
    }

    /**
     * Build negative prompt
     *
     * @param array $parameters
     * @return string
     */
    protected function buildNegativePrompt(array $parameters): string
    {
        $defaults = ['no vocals', 'no speech', 'no noise', 'no distortion'];

        if (!empty($parameters['negative_prompt'])) {
            $custom = array_map('trim', explode(',', $parameters['negative_prompt']));
            return implode(', ', array_unique(array_merge($defaults, $custom)));
        }

        return implode(', ', $defaults);
    }

    /**
     * Generate filename for audio file
     *
     * @param array $parameters
     * @return string
     */
    protected function generateFilename(array $parameters): string
    {
        $timestamp = now()->format('Ymd_His');
        $random = Str::random(8);
        $genre = Genre::find($parameters['genre_id'] ?? null)?->slug ?? 'music';

        return "music_{$genre}_{$timestamp}_{$random}";
    }

    /**
     * Generate title if not provided
     *
     * @param array $parameters
     * @return string
     */
    protected function generateTitle(array $parameters): string
    {
        $parts = [];

        if (!empty($parameters['mood'])) {
            $parts[] = ucfirst($parameters['mood']);
        }

        if (!empty($parameters['genre_id'])) {
            $genre = Genre::find($parameters['genre_id']);
            if ($genre) {
                $parts[] = $genre->name;
            }
        } else {
            $parts[] = 'Music';
        }

        if (!empty($parameters['style'])) {
            $parts[] = "({$parameters['style']})";
        }

        return implode(' ', $parts);
    }

    /**
     * Estimate generation cost
     *
     * @param array $parameters
     * @return float
     */
    protected function estimateCost(array $parameters): float
    {
        $duration = $parameters['duration'] ?? 30;
        $costPerSecond = config('music_generation.cost_estimation.per_second', 0.01);

        return round($duration * $costPerSecond, 2);
    }
}
