<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FeedbackAnalysisService
{
    public function analyzeFeedback(string $feedbackText): array
    {
        $provider = config('ai.default');
        $config = config("ai.providers.$provider");

        if (!$config || empty($config['endpoint'])) {
            return [
                'error' => "AI provider configuration not found or invalid: $provider",
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $config['api_key'],
                'Content-Type' => 'application/json',
            ])->post($config['endpoint'], [
                'model' => $config['model'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an AI assistant that analyzes customer feedback. Respond **only** with valid JSON: {"summary": "...", "sentiment": "positive|negative|neutral"}'
                    ],
                    [
                        'role' => 'user',
                        'content' => $feedbackText
                    ],
                ],
                'temperature' => 0.3,
            ]);
        } catch (\Throwable $e) {
            return [
                'error' => 'Exception while connecting to AI provider',
                'message' => $e->getMessage(),
            ];
        }

        if ($response->failed()) {
            return [
                'error' => 'Failed to connect to AI provider',
                'status' => $response->status(),
                'details' => $response->body(),
            ];
        }

        $data = $response->json();
        $content = $data['choices'][0]['message']['content'] ?? '';

        // Bersihkan blok ```json``` jika ada
        $clean = trim(preg_replace('/^```json|```$/m', '', $content));

        $parsed = json_decode($clean, true);

        if (!$parsed) {
            return [
                'error' => 'Failed to parse AI JSON',
                'raw' => $content,
            ];
        }

        return $parsed;
    }
}
