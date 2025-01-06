<?php

use App\Models\Constant;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Log::info('Starting project_employees table migration...');

            // Step 1: Drop existing table if exists
            Log::info('Step 1: Attempting to drop existing project_employees table...');
            if (Schema::hasTable('project_employees')) {
                Schema::dropIfExists('project_employees');
                Log::info('Successfully dropped existing project_employees table');
            } else {
                Log::info('No existing project_employees table found to drop');
            }

            // Step 2: Create new table
            Log::info('Step 2: Creating new project_employees table...');
            Schema::create('project_employees', function (Blueprint $table) {
                try {
                    Log::info('Creating table structure...');

                    // Adding primary key
                    Log::info('Adding ID column...');
                    $table->id();

                    // Adding employee foreign key
                    Log::info('Adding employee_id foreign key...');
                    $table->foreignId(Employee::ui['_id'])
                        ->constrained(Employee::ui['table']);

                    // Adding project foreign key
                    Log::info('Adding project_id foreign key...');
                    $table->foreignId(Project::ui['_id'])
                        ->constrained(Project::ui['table']);

                    // Adding position foreign key
                    Log::info('Adding position_id foreign key...');
                    $table->foreignId('position_id')
                        ->constrained(Constant::ui['table']);

                    // Adding order column
                    Log::info('Adding order column...');
                    $table->integer('order')->default(0);

                    // Adding timestamps and soft deletes
                    Log::info('Adding timestamps and soft deletes...');
                    $table->softDeletes();
                    $table->timestamps();

                    Log::info('Table structure creation completed successfully');
                } catch (\Exception $e) {
                    Log::error('Error in table creation: ' . $e->getMessage());
                    throw $e;
                }
            });

            // Final verification
            if (Schema::hasTable('project_employees')) {
                Log::info('Migration completed successfully. Table exists and has been created with all columns.');

                // Log table structure
                $columns = DB::select('SHOW COLUMNS FROM project_employees');
                Log::info('Final table structure:', ['columns' => collect($columns)->pluck('Field')->toArray()]);

                // Log indexes
                $indexes = DB::select('SHOW INDEXES FROM project_employees');
                Log::info('Table indexes:', ['indexes' => collect($indexes)->pluck('Key_name')->unique()->toArray()]);
            } else {
                Log::error('Migration failed: Table does not exist after creation attempt');
                throw new \Exception('Table creation failed');
            }
        } catch (\Exception $e) {
            Log::error('Migration failed with error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Log::info('Starting rollback of project_employees migration...');

            if (Schema::hasTable('project_employees')) {
                Schema::dropIfExists('project_employees');
                Log::info('Successfully rolled back project_employees table');
            } else {
                Log::info('No table found to roll back');
            }
        } catch (\Exception $e) {
            Log::error('Rollback failed with error: ' . $e->getMessage());
            throw $e;
        }
    }
};
