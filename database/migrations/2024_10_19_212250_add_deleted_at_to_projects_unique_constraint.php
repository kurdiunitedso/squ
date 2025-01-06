<?php

use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Log::info('Starting index modification on projects table');

        Schema::table(Project::ui['table'], function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['contract_id']);
            Log::info('Dropped foreign key constraint on contract_id');

            // Drop the unique index
            $table->dropUnique('projects_contract_id_item_id_unique');
            Log::info('Dropped projects_contract_id_item_id_unique index');

            // Recreate the foreign key constraint
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            Log::info('Recreated foreign key constraint on contract_id');

            // Add the new non-unique index including deleted_at
            $table->index(['contract_id', 'contract_item_id', 'deleted_at'], 'projects_soft_delete_index');
            Log::info('Added projects_soft_delete_index');
        });

        Log::info('Successfully completed index modifications');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Project::ui['table'], function (Blueprint $table) {});

        Log::info('Reverted index changes in projects table');
    }
};
