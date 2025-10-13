<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\FeedbackAnalysisService;

class FeedbackAnalysisServiceTest extends TestCase
{
    public function test_returns_parsed_json_when_success()
    {
        // Fake respons sukses dari AI provider
        Http::fake([
            '*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => '{"summary":"Good product","sentiment":"positive"}'
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Jalankan service
        $service = new FeedbackAnalysisService();
        $result = $service->analyzeFeedback('The product was amazing!');

        // Pastikan hasilnya sesuai
        $this->assertEquals('Good product', $result['summary']);
        $this->assertEquals('positive', $result['sentiment']);
    }

    public function test_returns_error_when_ai_provider_invalid()
    {
        // Simulasikan config provider yang salah
        config(['ai.default' => 'invalid_provider']);
        config(['ai.providers.invalid_provider' => []]);

        $service = new FeedbackAnalysisService();
        $result = $service->analyzeFeedback('Feedback text');

        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('AI provider configuration not found', $result['error']);
    }

    public function test_returns_error_when_ai_fails()
    {
        // Fake respons gagal dari AI
        Http::fake([
            '*' => Http::response([], 500)
        ]);

        $service = new FeedbackAnalysisService();
        $result = $service->analyzeFeedback('Something bad happened');

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Failed to connect to AI provider', $result['error']);
    }

    public function test_returns_error_when_invalid_json()
    {
        // Fake respons dengan JSON yang tidak valid
        Http::fake([
            '*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Not a valid JSON output']]
                ]
            ], 200)
        ]);

        $service = new FeedbackAnalysisService();
        $result = $service->analyzeFeedback('Invalid format test');

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Failed to parse AI JSON', $result['error']);
    }
}
