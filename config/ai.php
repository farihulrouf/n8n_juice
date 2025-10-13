<?php

return [
    // Provider default (bisa diubah di .env)
    'default' => env('AI_PROVIDER', 'mistral'),

    // Konfigurasi masing-masing provider
    'providers' => [
        'mistral' => [
            'api_key' => env('MISTRAL_API_KEY'),
            'endpoint' => env('MISTRAL_API_URL', 'https://api.mistral.ai/v1/chat/completions'),
            'model' => env('MISTRAL_MODEL', 'mistral-small'),
        ],
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'endpoint' => env('OPENAI_API_URL', 'https://api.openai.com/v1/chat/completions'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        ],
        // Kamu bisa tambah lagi nanti (Claude, Gemini, dsb)
    ],
];
