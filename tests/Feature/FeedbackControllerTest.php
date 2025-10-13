<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class FeedbackControllerTest extends TestCase
{
    public function test_successful_analysis_returns_json()
    {
        // Fake response dari AI
        Http::fake([
            '*' => Http::response([
                'choices' => [
                    ['message' => ['content' => '{"summary": "Good", "sentiment": "positive"}']]
                ]
            ], 200)
        ]);

        $response = $this->postJson('/api/analyse-feedback', [
            'feedback_text' => 'The product is really good but shipping was slow.'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'summary' => 'Good',
                     'sentiment' => 'positive',
                 ]);
    }

    public function test_validation_fails_for_invalid_input()
    {
        $response = $this->postJson('/api/analyse-feedback', [
            'feedback_text' => '12345'
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure(['message', 'errors']);
    }

    public function test_handles_ai_error_gracefully()
    {
        Http::fake([
            '*' => Http::response([], 500)
        ]);

        $response = $this->postJson('/api/analyse-feedback', [
            'feedback_text' => 'This should trigger AI error handling.'
        ]);

        $response->assertStatus(500)
                 ->assertJsonStructure(['message', 'details']);
    }
}
