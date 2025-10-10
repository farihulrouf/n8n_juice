<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FeedbackAnalysisService
{
    public function analyzeFeedback(string $feedbackText): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('MISTRAL_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('MISTRAL_API_ENDPOINT', 'https://api.mistral.ai/v1/chat/completions'), [
            'model' => 'mistral-small', // bisa juga 'mistral-large-latest'
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

        if ($response->failed()) {
            return [
                'error' => 'Failed to connect to Mistral API',
                'status' => $response->status(),
                'details' => $response->body()
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
                'raw' => $content
            ];
        }

        return $parsed;
    }
}
