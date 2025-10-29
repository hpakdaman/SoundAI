<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vertex AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google Vertex AI Music Generation API
    |
    */

    'vertex_ai' => [
        'project_id' => env('VERTEX_AI_PROJECT_ID'),
        'location' => env('VERTEX_AI_LOCATION', 'us-central1'),
        'api_endpoint' => env('VERTEX_AI_ENDPOINT', 'https://us-central1-aiplatform.googleapis.com'),
        'model' => env('VERTEX_AI_MODEL', 'music-generation-v1'),
        'timeout' => env('VERTEX_AI_TIMEOUT', 180), // seconds
        'max_retries' => env('VERTEX_AI_MAX_RETRIES', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Prompt Patterns
    |--------------------------------------------------------------------------
    |
    | Different prompt templates for music generation
    | Variables available: {genre}, {vibe}, {instruments}, {tempo}, {duration},
    | {key}, {time_signature}, {style_keywords}
    |
    */

    'prompt_patterns' => [

        'standard' => [
            'name' => 'Standard',
            'description' => 'Basic prompt structure for general music generation',
            'template' => 'Generate a {genre} music track with {vibe} mood. Duration: {duration} seconds. Tempo: {tempo} BPM. Featured instruments: {instruments}.',
            'min_tokens' => 50,
            'max_tokens' => 200,
        ],

        'detailed' => [
            'name' => 'Detailed',
            'description' => 'Comprehensive prompt with all musical parameters',
            'template' => 'Create a professional {genre} music composition with the following specifications:
                - Mood/Vibe: {vibe}
                - Primary Instruments: {instruments}
                - Tempo: {tempo} BPM
                - Duration: {duration} seconds
                - Key Signature: {key}
                - Time Signature: {time_signature}
                - Style Keywords: {style_keywords}

                Ensure high-quality production with balanced mixing and mastering.',
            'min_tokens' => 100,
            'max_tokens' => 500,
        ],

        'creative' => [
            'name' => 'Creative',
            'description' => 'Artistic and expressive prompt for unique compositions',
            'template' => 'Compose an innovative and expressive {genre} piece that evokes {vibe} emotions.
                Blend {instruments} in a unique arrangement.
                Tempo should be around {tempo} BPM, lasting {duration} seconds.
                Push creative boundaries while maintaining musical coherence.
                Additional creative direction: {style_keywords}',
            'min_tokens' => 80,
            'max_tokens' => 400,
        ],

        'technical' => [
            'name' => 'Technical',
            'description' => 'Precise technical specifications for expert-level control',
            'template' => 'Technical Music Generation Request:
                Genre: {genre}
                Emotional Profile: {vibe}
                Instrumentation: {instruments}
                Technical Parameters:
                - Tempo: {tempo} BPM (strict adherence)
                - Duration: {duration} seconds (precise)
                - Key: {key} (maintain throughout)
                - Time Signature: {time_signature}
                - Production Style: {style_keywords}

                Apply professional mixing techniques with appropriate dynamics, EQ, and spatial effects.',
            'min_tokens' => 120,
            'max_tokens' => 600,
        ],

        'minimal' => [
            'name' => 'Minimal',
            'description' => 'Short and concise prompt for quick generation',
            'template' => '{genre}, {vibe}, {instruments}, {tempo} BPM, {duration}s',
            'min_tokens' => 20,
            'max_tokens' => 100,
        ],

        'cinematic' => [
            'name' => 'Cinematic',
            'description' => 'Epic and dramatic compositions for film and media',
            'template' => 'Create an epic cinematic {genre} composition that conveys {vibe} atmosphere.
                Feature {instruments} with orchestral depth and dramatic build-ups.
                Tempo: {tempo} BPM, Duration: {duration} seconds.
                Build tension and release throughout. Perfect for film scoring and trailers.
                Style: {style_keywords}',
            'min_tokens' => 90,
            'max_tokens' => 450,
        ],

        'ambient' => [
            'name' => 'Ambient',
            'description' => 'Atmospheric and textural soundscapes',
            'template' => 'Generate an atmospheric {genre} soundscape with {vibe} qualities.
                Use {instruments} to create evolving textures and layers.
                Tempo: {tempo} BPM (subtle and flowing)
                Duration: {duration} seconds
                Focus on space, reverb, and subtle harmonic movements.
                Key: {key}, Additional elements: {style_keywords}',
            'min_tokens' => 75,
            'max_tokens' => 350,
        ],

        'energetic' => [
            'name' => 'Energetic',
            'description' => 'High-energy and upbeat compositions',
            'template' => 'Create a high-energy {genre} track with intense {vibe} drive!
                Feature powerful {instruments} with strong rhythm section.
                Fast tempo: {tempo} BPM, Duration: {duration} seconds.
                Dynamic range with explosive drops and builds.
                Keep the energy level consistently high.
                Style: {style_keywords}',
            'min_tokens' => 70,
            'max_tokens' => 350,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Generation Parameters
    |--------------------------------------------------------------------------
    |
    | Default and constraint parameters for music generation
    |
    */

    'parameters' => [
        'tempo' => [
            'min' => 20,
            'max' => 300,
            'default' => 120,
            'unit' => 'BPM',
        ],
        'duration' => [
            'min' => 10,
            'max' => 600,
            'default' => 180,
            'unit' => 'seconds',
        ],
        'quality' => [
            'sample_rate' => 44100,
            'bit_depth' => 16,
            'format' => 'mp3',
            'bitrate' => 320, // kbps
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Keyword Mappings
    |--------------------------------------------------------------------------
    |
    | Additional keywords to enhance prompts based on musical attributes
    |
    */

    'keyword_mappings' => [
        'tempo_descriptors' => [
            '0-60' => 'very slow, largo, grave',
            '60-80' => 'slow, adagio',
            '80-108' => 'moderate, andante',
            '108-140' => 'moderately fast, allegretto',
            '140-180' => 'fast, allegro',
            '180-300' => 'very fast, presto, vivace',
        ],

        'vibe_enhancements' => [
            'happy' => 'uplifting, joyful, cheerful, bright, positive',
            'sad' => 'melancholic, somber, emotional, reflective, mournful',
            'energetic' => 'dynamic, powerful, intense, driving, vigorous',
            'calm' => 'peaceful, serene, tranquil, soothing, relaxing',
            'dark' => 'mysterious, ominous, brooding, atmospheric, haunting',
            'romantic' => 'passionate, tender, intimate, heartfelt, emotional',
            'epic' => 'grandiose, heroic, cinematic, dramatic, majestic',
            'mysterious' => 'enigmatic, suspenseful, intriguing, cryptic, curious',
        ],

        'production_styles' => [
            'modern' => 'contemporary production, clean mix, tight dynamics',
            'vintage' => 'analog warmth, retro feel, lo-fi aesthetic',
            'cinematic' => 'orchestral depth, wide soundstage, dramatic dynamics',
            'electronic' => 'synthesized sounds, digital processing, modern textures',
            'acoustic' => 'natural instruments, organic feel, live performance quality',
            'experimental' => 'unconventional sounds, creative processing, unique arrangements',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Musical Keys & Scales
    |--------------------------------------------------------------------------
    |
    | Reference for key signatures and their characteristics
    |
    */

    'musical_keys' => [
        'major' => [
            'C' => 'bright, pure, simple',
            'G' => 'joyful, pastoral, calm',
            'D' => 'triumphant, victorious, strong',
            'A' => 'confident, open, bright',
            'E' => 'passionate, heroic, brilliant',
            'B' => 'harsh, strong, wild',
            'F#' => 'conquest, relief, triumph',
            'C#' => 'pure, serene, tender',
            'F' => 'peaceful, calm, pastoral',
            'Bb' => 'cheerful, magnificent, joyous',
            'Eb' => 'serious, majestic, deep',
            'Ab' => 'warm, full, velvety',
            'Db' => 'grief, depressive, dark',
            'Gb' => 'mystical, dreamy, magical',
        ],
        'minor' => [
            'A' => 'tender, plaintive, pious',
            'E' => 'naive, womanly, innocent',
            'B' => 'lonely, melancholic, patient',
            'F#' => 'resentful, anxious, complaining',
            'C#' => 'despair, wailing, weeping',
            'G#' => 'grumbling, moaning, discontent',
            'D#' => 'feelings of anxiety, deep distress',
            'A#' => 'cruel, bitter, dark',
            'D' => 'melancholic, serious, pious',
            'G' => 'discontent, uneasiness, anxiety',
            'C' => 'obscure, sad, funeral',
            'F' => 'harrowing, melancholic, awe',
            'Bb' => 'dark, terrible, melancholic',
            'Eb' => 'horrible, frightful, cruel',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Time Signatures
    |--------------------------------------------------------------------------
    |
    | Common time signatures and their characteristics
    |
    */

    'time_signatures' => [
        '4/4' => 'Common time - most popular, balanced, versatile',
        '3/4' => 'Waltz time - flowing, dance-like, graceful',
        '6/8' => 'Compound meter - lilting, rolling, flowing',
        '2/4' => 'March time - steady, march-like, strong',
        '5/4' => 'Irregular meter - unusual, complex, progressive',
        '7/8' => 'Irregular meter - complex, rhythmic, intense',
        '12/8' => 'Compound quadruple - smooth, blues-like, flowing',
        '9/8' => 'Compound triple - flowing, expansive, graceful',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cost Estimation
    |--------------------------------------------------------------------------
    |
    | Pricing structure for API usage tracking
    |
    */

    'cost_estimation' => [
        'base_cost' => 0.01, // per request
        'duration_multiplier' => 0.001, // per second
        'quality_multiplier' => [
            'standard' => 1.0,
            'high' => 1.5,
            'premium' => 2.0,
        ],
        'currency' => 'USD',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Storage
    |--------------------------------------------------------------------------
    |
    | Configuration for audio file storage
    |
    */

    'storage' => [
        'disk' => env('MUSIC_STORAGE_DISK', 'public'),
        'directory' => 'compositions',
        'subdirectories' => [
            'audio' => 'audio',
            'waveforms' => 'waveforms',
            'metadata' => 'metadata',
        ],
        'max_file_size' => 50 * 1024 * 1024, // 50MB in bytes
        'allowed_formats' => ['mp3', 'wav', 'ogg', 'flac', 'm4a'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for queued music generation jobs
    |
    */

    'queue' => [
        'connection' => env('MUSIC_QUEUE_CONNECTION', 'redis'),
        'queue_name' => env('MUSIC_QUEUE_NAME', 'music-generation'),
        'timeout' => 300, // seconds
        'max_attempts' => 3,
        'backoff' => [60, 120, 300], // seconds between retries
    ],

];
