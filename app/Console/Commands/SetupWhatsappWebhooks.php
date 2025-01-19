<?php

namespace App\Console\Commands;

use App\Services\CP\Whatsapp\WhatsappService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SetupWhatsappWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:setup-webhooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup WhatsApp webhook subscriptions';

    /**
     * Execute the console command.
     */
    public function handle(WhatsappService $whatsappService)
    {
        $this->info('Starting WhatsApp webhook setup...');

        try {
            $result = $whatsappService->subscribeToWebhooks();

            if ($result['success']) {
                $this->info('✓ Webhooks configured successfully!');
                $this->table(
                    ['Field', 'Status'],
                    [
                        ['messages', 'Subscribed'],
                        ['message_status_updates', 'Subscribed'],
                        ['message_template_status_update', 'Subscribed']
                    ]
                );
            } else {
                $this->error('Failed to configure webhooks!');
                $this->error('Error: ' . ($result['error'] ?? 'Unknown error'));
                Log::error('WhatsApp webhook setup failed', $result);
            }
        } catch (\Exception $e) {
            $this->error('An error occurred during setup!');
            $this->error($e->getMessage());
            Log::error('WhatsApp webhook setup exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
