<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;

class UpdateCountryNamesToTranslatable extends Command
{
    protected $signature = 'countries:update-names';
    protected $description = 'Convert country names to translatable format';

    public function handle()
    {
        $this->info('Starting to update country names...');

        $updatedCount = 0;
        $skippedCount = 0;

        Country::chunk(100, function ($countries) use (&$updatedCount, &$skippedCount) {
            foreach ($countries as $country) {
                $oldName = $country->getRawOriginal('name');

                // Check if it's already in JSON format
                if ($this->isJsonString($oldName)) {
                    $this->line("Skipped country ID: {$country->id} - Already converted");
                    $skippedCount++;
                    continue;
                }

                // Convert to translatable format
                $country->name = [
                    'en' => $oldName,
                    'ar' => $oldName
                ];

                $country->save();

                $this->info("Updated country ID: {$country->id}");
                $updatedCount++;
            }
        });

        $this->info('Conversion completed!');
        $this->info("Total records updated: {$updatedCount}");
        $this->info("Total records skipped: {$skippedCount}");
    }

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
