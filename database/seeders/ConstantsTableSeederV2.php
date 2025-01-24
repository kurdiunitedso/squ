<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use App\Services\Constants\ConstantService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ConstantsTableSeederV2 extends Seeder
{
    /**
     * Define the constants configuration
     */
    protected array $constants = [
        [
            'module' => Modules::attachment_module,
            'items' => [

                [
                    'field' => DropDownFields::program_attachment_type,
                    'values' => DropDownFields::program_attachment_type_list
                ]
            ]
        ],
        [
            'module' => Modules::program_module,
            'items' => [
                [
                    'field' => DropDownFields::program_eligibility_type,
                    'values' => DropDownFields::program_eligibility_type_list
                ],
                [
                    'field' => DropDownFields::program_target_applicants,
                    'values' => DropDownFields::program_target_applicants_list
                ],
                [
                    'field' => DropDownFields::program_category,
                    'values' => DropDownFields::program_category_list
                ],
                [
                    'field' => DropDownFields::program_facility,
                    'values' => DropDownFields::program_facility_list
                ],
                [
                    'field' => DropDownFields::program_attachment_type,
                    'values' => DropDownFields::program_attachment_type_list
                ]
            ]
        ]
    ];

    public function run(): void
    {
        $this->logStart();

        try {
            // Add debug logging
            Log::info('Program attachment type list:', [
                'values' => DropDownFields::program_attachment_type_list
            ]);

            Log::info('Constants configuration:', [
                'module' => $this->constants[0]['module'],
                'field' => $this->constants[0]['items'][0]['field'],
                'values' => $this->constants[0]['items'][0]['values']
            ]);
            // Clear cache
            $this->clearCache();

            // Seed constants
            foreach ($this->constants as $moduleGroup) {
                $module = $moduleGroup['module'];
                $this->logModuleStart($module);

                foreach ($moduleGroup['items'] as $item) {
                    // Add this check and pass children config
                    $childConfig = isset($item['children']) ? $item['children'] : null;
                    $this->seedConstants($module, $item['field'], $item['values'], $childConfig);
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

    private function seedConstants(string $module, string $field, array $values, ?array $childConfig = null): void
    {
        Log::info("Starting to seed constants for {$module} - {$field}");

        $successCount = 0;
        $updateCount = 0;
        $errorCount = 0;

        foreach ($values as $key => $value) {
            try {
                $constantName = is_numeric($key) ? $value : $key;
                $color = DropDownFields::colors_list[$constantName] ?? null;

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

                // Handle child constants if they exist
                if ($childConfig && isset($childConfig['values'][$constantName])) {
                    $this->seedChildConstants(
                        $module,
                        $childConfig['field'],
                        $childConfig['values'][$constantName],
                        $constant->id
                    );
                }

                if ($wasExisting) {
                    $updateCount++;
                } else {
                    $successCount++;
                }
            } catch (\Exception $e) {
                $errorCount++;
                Log::error("Error processing constant {$constantName}: " . $e->getMessage());
            }
        }

        $summary = "Completed seeding {$field}: Created {$successCount}, Updated {$updateCount}, Errors {$errorCount}";
        Log::info($summary);
    }

    private function seedChildConstants(string $module, string $field, array $children, int $parentId): void
    {
        foreach ($children as $key => $value) {
            $childName = is_numeric($key) ? $value : $key;

            Constant::updateOrCreate(
                [
                    'constant_name' => $childName,
                    'module' => $module,
                    'field' => $field,
                    'parent_id' => $parentId,
                ],
                [
                    'name' => [
                        'en' => splitAndUppercase($childName),
                        'ar' => t(splitAndUppercase($childName), [], 'ar'),
                    ],
                    'value' => $value,
                ]
            );
        }
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
