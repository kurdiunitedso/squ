<?php

// Feature test for the webhook endpoint
namespace Tests\Feature\CP;

use Tests\TestCase;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class WhatsAppWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'graph.facebook.com/*' => Http::response(['success' => true], 200)
        ]);
    }

    /** @test */
    public function webhook_handles_verification_correctly()
    {
        $challenge = 'challenge_code';

        $response = $this->get('/api/webhook/whatsapp?' . http_build_query([
            'hub_mode' => 'subscribe',
            'hub_verify_token' => config('services.whatsapp.verify_token'),
            'hub_challenge' => $challenge
        ]));

        $response->assertStatus(200);
        $response->assertSeeText($challenge);
    }

    /** @test */
    public function webhook_rejects_invalid_verification_token()
    {
        $response = $this->get('/api/webhook/whatsapp?' . http_build_query([
            'hub_mode' => 'subscribe',
            'hub_verify_token' => 'invalid_token',
            'hub_challenge' => 'challenge'
        ]));

        $response->assertStatus(403);
    }

    /** @test */
    public function webhook_processes_incoming_message()
    {
        $phoneNumber = '201069151219';

        $payload = [
            'entry' => [[
                'changes' => [[
                    'value' => [
                        'messages' => [[
                            'from' => $phoneNumber,
                            'type' => 'text',
                            'text' => [
                                'body' => 'Hello'
                            ],
                            'timestamp' => time()
                        ]]
                    ]
                ]]
            ]]
        ];

        $response = $this->postJson('/api/webhook/whatsapp', $payload);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('chat_sessions', [
            'phone_number' => $phoneNumber
        ]);
    }
}
