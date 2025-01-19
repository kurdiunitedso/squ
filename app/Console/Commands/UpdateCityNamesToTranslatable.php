<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;

class UpdateCityNamesToTranslatable extends Command
{
    protected $signature = 'cities:update-names';
    protected $description = 'Convert city names to translatable format';

    public function handle()
    {
        $this->info('Starting to update city names...');

        $updatedCount = 0;
        $skippedCount = 0;

        City::chunk(100, function ($cities) use (&$updatedCount, &$skippedCount) {
            foreach ($cities as $city) {
                $oldName = $city->getRawOriginal('name');

                // Check if it's already in JSON format
                if ($this->isJsonString($oldName)) {
                    $this->line("Skipped city ID: {$city->id} - Already converted");
                    $skippedCount++;
                    continue;
                }

                // Convert to translatable format
                $city->name = [
                    'en' => $oldName,
                    'ar' => $oldName
                ];

                $city->save();

                $this->info("Updated city ID: {$city->id}");
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
