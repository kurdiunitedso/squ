<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use App\Services\Constants\ConstantService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ConstantsTableSeederV1 extends Seeder
{
    /**
     * Define the constants configuration
     */
    protected array $constants = [

        [
            'module' => Modules::website_sections_module,
            'items' => [
                [
                    'field' => DropDownFields::website_section_type,
                    'values' => DropDownFields::website_section_type_list
                ],


            ]
        ],

    ];

    public function run(): void
    {
        $this->logStart();

        try {
            // Clear cache
            $this->clearCache();

            // Seed constants
            foreach ($this->constants as $moduleGroup) {
                $module = $moduleGroup['module'];
                $this->logModuleStart($module);

                foreach ($moduleGroup['items'] as $item) {
                    $this->seedConstants($module, $item['field'], $item['values']);
                }

                $this->logModuleEnd($module);
            }

            // Verify seeding
            $this->verifySeeding();

            $this->logSuccess();
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    private function clearCache(): void
    {
        Log::info('Starting cache cleanup...');
        Cache::flush();
        Log::info('Cache cleanup completed');
        $this->command->info('Cache cleared successfully');
    }

    private function seedConstants(string $module, string $field, array $values): void
    {
        Log::info("Starting to seed constants for {$module} - {$field}");
        // $this->command->info("Processing {$field} for module {$module}");

        $successCount = 0;
        $updateCount = 0;
        $errorCount = 0;

        foreach ($values as $key => $value) {
            try {
                $constantName = is_numeric($key) ? $value : $key;

                // Get color if it exists for this field and constant
                $color = DropDownFields::colors_list/*[$field]*/[$constantName] ?? null;

                $wasExisting = Constant::where([
                    'constant_name' => $constantName,
                    'module' => $module,
                    'field' => $field,
                ])->exists();

                $constantData = [
                    'name' => [
                        'en' => splitAndUppercase($constantName),
                        'ar' => t(splitAndUppercase($constantName), [], 'ar'),
                    ],
                    'value' => $value,
                    'parent_id' => null,
                ];

                // Add color if it exists
                if ($color) {
                    $constantData['color'] = $color;
                }

                $constant = Constant::updateOrCreate(
                    [
                        'constant_name' => $constantName,
                        'module' => $module,
                        'field' => $field,
                    ],
                    $constantData
                );

                if ($wasExisting) {
                    $updateCount++;
                } else {
                    $successCount++;
                }
            } catch (\Exception $e) {
                $errorCount++;
                Log::error("Error processing constant {$constantName}: " . $e->getMessage(), [
                    'exception' => $e,
                    'module' => $module,
                    'field' => $field,
                    'value' => $value
                ]);
            }
        }

        $summary = "Completed seeding {$field}: Created {$successCount}, Updated {$updateCount}, Errors {$errorCount}";
        Log::info($summary);
        // $this->command->info($summary);
    }

    private function verifySeeding(): void
    {
        Log::info('Starting verification process...');
        $this->command->info('Verifying seeded data...');

        $totalConstants = 0;
        foreach ($this->constants as $moduleGroup) {
            $module = $moduleGroup['module'];

            foreach ($moduleGroup['items'] as $item) {
                $count = Constant::where('module', $module)
                    ->where('field', $item['field'])
                    ->count();

                $totalConstants += $count;

                $message = "Verified {$count} constants for {$module} - {$item['field']}";
                Log::info($message);
                $this->command->info($message);

                // Log details of each constant for debugging
                $constants = Constant::where('module', $module)
                    ->where('field', $item['field'])
                    ->get();

                foreach ($constants as $constant) {
                    Log::debug("Verified constant:", [
                        'id' => $constant->id,
                        'name' => $constant->name,
                        'value' => $constant->value,
                        'module' => $constant->module,
                        'field' => $constant->field
                    ]);
                }
            }
        }

        $finalMessage = "Total constants verified: {$totalConstants}";
        Log::info($finalMessage);
        $this->command->info($finalMessage);
    }

    private function logStart(): void
    {
        Log::info('=== Starting Constants Seeding Process ===');
        $this->command->info('Starting constants seeding...');
    }

    private function logModuleStart(string $module): void
    {
        Log::info("Starting to process module: {$module}");
        // $this->command->info("Processing module: {$module}");
    }

    private function logModuleEnd(string $module): void
    {
        Log::info("Completed processing module: {$module}");
        $this->command->info("Completed module: {$module}");
    }

    private function logSuccess(): void
    {
        $message = '=== Constants Seeding Completed Successfully ===';
        Log::info($message);
        $this->command->info($message);
    }

    private function logError(\Exception $e): void
    {
        $message = "Error during seeding: " . $e->getMessage();
        Log::error($message, [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);
        $this->command->error($message);
    }
}
