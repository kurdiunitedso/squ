<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;

class UpdateLeadNamesToTranslatable extends Command
{
    protected $signature = 'leads:update-names';
    protected $description = 'Convert lead names to translatable format';

    public function handle()
    {
        $this->info('Starting to update lead names...');

        $updatedCount = 0;
        $skippedCount = 0;

        Lead::chunk(100, function ($leads) use (&$updatedCount, &$skippedCount) {
            foreach ($leads as $lead) {
                $oldName = $lead->getRawOriginal('name');

                // Check if it's already in JSON format
                if ($this->isJsonString($oldName)) {
                    $this->line("Skipped lead ID: {$lead->id} - Already converted");
                    $skippedCount++;
                    continue;
                }

                // Convert to translatable format
                $lead->name = [
                    'en' => $oldName,
                    'ar' => $oldName
                ];

                $lead->save();

                $this->info("Updated lead ID: {$lead->id}");
                $updatedCount++;
            }
        });

        $this->info('Conversion completed!');
        $this->info("Total records updated: {$updatedCount}");
        $this->info("Total records skipped: {$skippedCount}");
    }

    /**
     * Check if a string is valid JSON and has required language keys
     */
    private function isJsonString($string): bool
    {
        if (!is_string($string)) {
            return false;
        }

        try {
            $json = json_decode($string, true);
            return (json_last_error() === JSON_ERROR_NONE)
                && is_array($json)
                && isset($json['en'])
                && isset($json['ar']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
