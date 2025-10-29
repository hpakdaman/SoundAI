<?php
/**
 * Vertex AI Music Generator (Verbose Logging to File)
 * Logs full API response to a file for debugging if audioContent is empty
 */

$PROJECT_ID = 'gen-lang-client-0468335962';
$LOCATION   = 'us-central1';
$MODEL_ID   = 'lyria-002';

$USE_GCLOUD_AUTH = true;
$ACCESS_TOKEN = ''; // اگر از gcloud استفاده نمی‌کنی اینجا بذار

$PROMPT = 'Emotional rock track .';
// $PROMPT = 'Epic high-energy rock track with powerful electric guitars, driving bass, and punchy drums. Include soaring guitar solos, aggressive riffs, and a dynamic, stadium-filling sound. Make it intense, modern, and cinematic, perfect for action scenes or adrenaline-pumping moments.';
// $PROMPT = 'Energetic electric guitar track with driving rhythm, modern rock feel, and intense energy. Include tight drums and powerful bass.';
$NEGATIVE_PROMPT = 'no vocals, no noise, no distortion';
$SEED = 42;

$logFile = 'music_api_response_' . time() . '.json';

echo "═══════════════════════════════════════\n";
echo "🎼 Vertex AI Music Generator (Verbose to File)\n";
echo "═══════════════════════════════════════\n\n";

// 1️⃣ Access token
if ($USE_GCLOUD_AUTH) {
    echo "🔑 Getting access token from gcloud...\n";
    $ACCESS_TOKEN = trim(shell_exec('gcloud auth print-access-token 2>&1'));

    if (empty($ACCESS_TOKEN) || strpos($ACCESS_TOKEN, 'ERROR') !== false) {
        die("❌ Failed to get access token. Run: gcloud auth login\n");
    }
    echo "✅ Got access token\n\n";
} elseif (empty($ACCESS_TOKEN)) {
    die("❌ Please set your ACCESS_TOKEN or enable gcloud auth.\n");
}

// 2️⃣ Endpoint
$endpoint = "https://{$LOCATION}-aiplatform.googleapis.com/v1/projects/{$PROJECT_ID}/locations/{$LOCATION}/publishers/google/models/{$MODEL_ID}:predict";

// 3️⃣ Request body
$requestBody = [
    "instances" => [
        [
            "prompt" => $PROMPT,
            "negative_prompt" => $NEGATIVE_PROMPT,
            "seed" => $SEED
        ]
    ]
];

echo "🎵 Sending request to Vertex AI...\n";

// 4️⃣ CURL
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$ACCESS_TOKEN}"
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 90);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// 5️⃣ Handle errors
if ($error) {
    die("❌ CURL Error: $error\n");
}
if ($httpCode !== 200) {
    die("❌ HTTP Error $httpCode\n$response\n");
}

// 6️⃣ Decode JSON
$data = json_decode($response, true);

// 7️⃣ Save full API response to file for debugging
// file_put_contents($logFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
// echo "📋 Full API response saved to: {$logFile}\n\n";

// 8️⃣ Check audioContent
if (empty($data['predictions'][0]['bytesBase64Encoded'])) {
    die("❌ No audio data received. Check {$logFile} for full response.\n");
}

// 9️⃣ Save file WAV
$audioContent = $data['predictions'][0]['bytesBase64Encoded'];
$decoded = base64_decode($audioContent);
$filename = 'music-lyria-' . time() . '.wav';

file_put_contents($filename, $decoded);

$sizeMB = round(filesize($filename) / 1024 / 1024, 2);
echo "✅ Music generated successfully!\n";
echo "💾 Saved WAV: $filename ({$sizeMB} MB)\n\n";
echo "🎧 To play: open $filename\n";
echo "═══════════════════════════════════════\n";
