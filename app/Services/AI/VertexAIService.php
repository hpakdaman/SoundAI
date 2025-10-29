<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Firebase\JWT\JWT;

class VertexAIService
{
    protected string $projectId;
    protected string $location;
    protected string $modelId;
    protected ?string $serviceAccountPath;
    protected int $timeout;
    protected ?string $cachedToken = null;
    protected ?int $tokenExpiry = null;

    public function __construct()
    {
        $this->projectId = config('music_generation.vertex_ai.project_id');
        $this->location = config('music_generation.vertex_ai.location', 'us-central1');
        $this->modelId = config('music_generation.vertex_ai.model', 'lyria-002');
        $this->serviceAccountPath = config('music_generation.vertex_ai.service_account_path');
        $this->timeout = config('music_generation.vertex_ai.timeout', 90);
    }

    /**
     * Generate music from a text prompt
     *
     * @param string $prompt Main generation prompt
     * @param string|null $negativePrompt What to avoid in generation
     * @param int|null $seed Random seed for reproducibility
     * @return array ['success' => bool, 'audio_data' => string|null, 'error' => string|null, 'size_mb' => float|null]
     */
    public function generateMusic(string $prompt, ?string $negativePrompt = null, ?int $seed = null): array
    {
        try {
            Log::info('🎵 Starting Vertex AI music generation', [
                'prompt' => $prompt,
                'negative_prompt' => $negativePrompt,
                'seed' => $seed,
            ]);

            // Get access token
            $token = $this->getAccessToken();
            if (!$token) {
                return [
                    'success' => false,
                    'audio_data' => null,
                    'error' => 'Failed to obtain access token. Check service account configuration.',
                    'size_mb' => null,
                ];
            }

            // Build API endpoint
            $endpoint = "https://{$this->location}-aiplatform.googleapis.com/v1/projects/{$this->projectId}/locations/{$this->location}/publishers/google/models/{$this->modelId}:predict";

            // Build request body
            $requestBody = [
                'instances' => [
                    [
                        'prompt' => $prompt,
                    ]
                ]
            ];

            // Add optional parameters
            if ($negativePrompt) {
                $requestBody['instances'][0]['negative_prompt'] = $negativePrompt;
            }

            if ($seed !== null) {
                $requestBody['instances'][0]['seed'] = $seed;
            }

            Log::info('📤 Sending request to Vertex AI', [
                'endpoint' => $endpoint,
                'model' => $this->modelId,
            ]);

            // Make API request
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Content-Type' => 'application/json',
            ])
            ->timeout($this->timeout)
            ->post($endpoint, $requestBody);

            // Check for HTTP errors
            if (!$response->successful()) {
                $errorBody = $response->json();
                Log::error('❌ Vertex AI HTTP Error', [
                    'status' => $response->status(),
                    'error' => $errorBody,
                ]);

                return [
                    'success' => false,
                    'audio_data' => null,
                    'error' => "HTTP {$response->status()}: " . ($errorBody['error']['message'] ?? 'Unknown error'),
                    'size_mb' => null,
                ];
            }

            $data = $response->json();

            // Check for audio content
            if (empty($data['predictions'][0]['bytesBase64Encoded'])) {
                Log::error('❌ No audio data in response', ['response' => $data]);

                return [
                    'success' => false,
                    'audio_data' => null,
                    'error' => 'No audio data received from API',
                    'size_mb' => null,
                ];
            }

            // Get base64 encoded audio
            $audioContent = $data['predictions'][0]['bytesBase64Encoded'];
            $decoded = base64_decode($audioContent);
            $sizeMB = round(strlen($decoded) / 1024 / 1024, 2);

            Log::info('✅ Music generated successfully', [
                'size_mb' => $sizeMB,
                'duration' => $data['predictions'][0]['duration'] ?? 'unknown',
            ]);

            return [
                'success' => true,
                'audio_data' => $decoded,
                'error' => null,
                'size_mb' => $sizeMB,
                'metadata' => $data['predictions'][0] ?? [],
            ];

        } catch (\Exception $e) {
            Log::error('❌ Vertex AI Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'audio_data' => null,
                'error' => $e->getMessage(),
                'size_mb' => null,
            ];
        }
    }

    /**
     * Get OAuth2 access token from service account JSON file
     * Uses JWT to authenticate with Google OAuth2
     *
     * @return string|null
     */
    protected function getAccessToken(): ?string
    {
        // Return cached token if still valid
        if ($this->cachedToken && $this->tokenExpiry && time() < $this->tokenExpiry) {
            Log::debug('🔄 Using cached access token');
            return $this->cachedToken;
        }

        try {
            // Load service account JSON
            if (!$this->serviceAccountPath || !file_exists($this->serviceAccountPath)) {
                Log::error('❌ Service account file not found', [
                    'path' => $this->serviceAccountPath
                ]);
                return null;
            }

            $serviceAccount = json_decode(file_get_contents($this->serviceAccountPath), true);

            if (!$serviceAccount) {
                Log::error('❌ Invalid service account JSON');
                return null;
            }

            Log::info('🔑 Generating OAuth2 token from service account...');

            // Create JWT
            $now = time();
            $expiry = $now + 3600; // 1 hour

            $jwtPayload = [
                'iss' => $serviceAccount['client_email'],
                'sub' => $serviceAccount['client_email'],
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $expiry,
                'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            ];

            // Sign JWT with private key
            $jwt = JWT::encode($jwtPayload, $serviceAccount['private_key'], 'RS256');

            // Exchange JWT for access token
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            if (!$response->successful()) {
                Log::error('❌ Failed to get OAuth2 token', [
                    'status' => $response->status(),
                    'error' => $response->json(),
                ]);
                return null;
            }

            $tokenData = $response->json();
            $this->cachedToken = $tokenData['access_token'];
            $this->tokenExpiry = $now + ($tokenData['expires_in'] - 300); // 5 min buffer

            Log::info('✅ Got OAuth2 access token', [
                'expires_in' => $tokenData['expires_in'],
            ]);

            return $this->cachedToken;

        } catch (\Exception $e) {
            Log::error('❌ Exception getting access token', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Save audio data to storage
     *
     * @param string $audioData Raw WAV audio data
     * @param string $filename Filename without extension
     * @return string Path to saved file
     */
    public function saveAudioFile(string $audioData, string $filename): string
    {
        $disk = config('music_generation.storage.disk', 'public');
        $path = config('music_generation.storage.path', 'music');

        $fullPath = "{$path}/{$filename}.wav";

        Storage::disk($disk)->put($fullPath, $audioData);

        Log::info('💾 Audio file saved', [
            'disk' => $disk,
            'path' => $fullPath,
            'size_mb' => round(strlen($audioData) / 1024 / 1024, 2),
        ]);

        return $fullPath;
    }

    /**
     * Test connection to Vertex AI
     *
     * @return array
     */
    public function testConnection(): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Failed to obtain access token. Check service account configuration.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Successfully authenticated with Vertex AI using service account',
            'project_id' => $this->projectId,
            'location' => $this->location,
            'model' => $this->modelId,
        ];
    }
}
