<?php

namespace Tests\Unit\Services\CP\Whatsapp;

use Tests\TestCase;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Services\CP\Whatsapp\WhatsappService;
use App\Services\CP\Whatsapp\WhatsAppChatbotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class WhatsAppChatbotTest extends TestCase
{
    use RefreshDatabase;

    protected $chatbotService;
    protected $phoneNumber = '201069151219';

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the HTTP client
        Http::fake([
            'graph.facebook.com/*' => Http::response(['success' => true], 200)
        ]);

        $this->chatbotService = new WhatsAppChatbotService();

        // Ensure we're using SQLite for testing
        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', ':memory:');

        // Run migrations
        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function it_handles_initial_message_correctly()
    {
        // Arrange
        $payload = $this->createMessagePayload($this->phoneNumber, 'Hello');

        // Act
        $this->chatbotService->handleWebhook($payload);

        // Assert
        $this->assertDatabaseHas('chat_sessions', [
            'phone_number' => $this->phoneNumber,
            'current_state' => 'initial'
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'phone_number' => $this->phoneNumber,
            'message_type' => 'text',
            'content' => 'Hello',
            'direction' => 'incoming'
        ]);
    }

    /** @test */
    public function it_handles_name_input_correctly()
    {
        // Arrange
        ChatSession::create([
            'phone_number' => $this->phoneNumber,
            'current_state' => 'awaiting_name'
        ]);

        $payload = $this->createMessagePayload($this->phoneNumber, 'Mosab');

        // Act
        $this->chatbotService->handleWebhook($payload);

        // Assert
        $this->assertDatabaseHas('chat_sessions', [
            'phone_number' => $this->phoneNumber,
            'current_state' => 'awaiting_service_type'
        ]);

        $session = ChatSession::where('phone_number', $this->phoneNumber)->first();
        $this->assertEquals('Mosab', $session->user_data['name']);
    }

    /** @test */
    public function it_handles_service_selection_correctly()
    {
        // Arrange
        ChatSession::create([
            'phone_number' => $this->phoneNumber,
            'current_state' => 'awaiting_service_type',
            'user_data' => ['name' => 'Mosab']
        ]);

        $payload = $this->createInteractivePayload($this->phoneNumber, 'clinic', 'عيادة دورية أو منظار');

        // Act
        $this->chatbotService->handleWebhook($payload);

        // Assert
        $this->assertDatabaseHas('chat_sessions', [
            'phone_number' => $this->phoneNumber,
            'current_state' => 'clinic_selected'
        ]);

        $session = ChatSession::where('phone_number', $this->phoneNumber)->first();
        $this->assertEquals('clinic', $session->user_data['service_type']);
    }

    /** @test */
    public function it_handles_emergency_selection_correctly()
    {
        // Arrange
        ChatSession::create([
            'phone_number' => $this->phoneNumber,
            'current_state' => 'awaiting_service_type',
            'user_data' => ['name' => 'Mosab']
        ]);

        $payload = $this->createInteractivePayload($this->phoneNumber, 'emergency', 'طوارئ');

        // Act
        $this->chatbotService->handleWebhook($payload);

        // Assert
        $this->assertDatabaseHas('chat_sessions', [
            'phone_number' => $this->phoneNumber,
            'current_state' => 'emergency_selected'
        ]);

        $session = ChatSession::where('phone_number', $this->phoneNumber)->first();
        $this->assertEquals('emergency', $session->user_data['service_type']);
    }

    /** @test */
    public function it_stores_outgoing_messages()
    {
        // Arrange
        $payload = $this->createMessagePayload($this->phoneNumber, 'Hello');

        // Act
        $this->chatbotService->handleWebhook($payload);

        // Assert
        $this->assertDatabaseHas('chat_messages', [
            'phone_number' => $this->phoneNumber,
            'direction' => 'outgoing',
            'content' => 'مرحبا! أنا دينا مساعدك الآلي. سوف اساعدك بحجز موعدك عن مستشفى الأهلي'
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'phone_number' => $this->phoneNumber,
            'direction' => 'outgoing',
            'content' => 'هل يمكنني التعرف على اسمك الرباعي؟'
        ]);
    }

    /** @test */
    public function it_handles_invalid_message_gracefully()
    {
        // Arrange
        $invalidPayload = ['invalid' => 'data'];

        // Act
        $this->chatbotService->handleWebhook($invalidPayload);

        // Assert
        $this->assertDatabaseMissing('chat_messages', [
            'phone_number' => $this->phoneNumber
        ]);
    }

    // Helper methods to create test payloads
    protected function createMessagePayload(string $phoneNumber, string $message): array
    {
        return [
            'entry' => [[
                'changes' => [[
                    'value' => [
                        'messages' => [[
                            'from' => $phoneNumber,
                            'type' => 'text',
                            'text' => [
                                'body' => $message
                            ],
                            'timestamp' => time()
                        ]]
                    ]
                ]]
            ]]
        ];
    }

    protected function createInteractivePayload(string $phoneNumber, string $buttonId, string $buttonTitle): array
    {
        return [
            'entry' => [[
                'changes' => [[
                    'value' => [
                        'messages' => [[
                            'from' => $phoneNumber,
                            'type' => 'interactive',
                            'interactive' => [
                                'type' => 'button_reply',
                                'button_reply' => [
                                    'id' => $buttonId,
                                    'title' => $buttonTitle
                                ]
                            ],
                            'timestamp' => time()
                        ]]
                    ]
                ]]
            ]]
        ];
    }
}
