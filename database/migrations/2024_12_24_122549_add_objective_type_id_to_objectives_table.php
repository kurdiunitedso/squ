<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // In the new migration file:
    public function up()
    {
        Schema::table('objectives', function (Blueprint $table) {
            $table->foreignId('objective_type_id')->nullable()->after('name')->constrained('constants')->onDelete('cascade');
        });
        Schema::table('contracts', function (Blueprint $table) {
            $table->foreignId('objective_type_id')->nullable()->after('type_id')->constrained('constants')->onDelete('cascade');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('objective_type_id')->nullable()->after('item_id')->constrained('constants')->onDelete('cascade');
        });
        Schema::table('offers', function (Blueprint $table) {
            // Check if the status column exists
            if (Schema::hasColumn('offers', 'status')) {
                // Check if there's a foreign key constraint before attempting to drop it
                $foreignKeys = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableForeignKeys('offers');

                $statusForeignKeyExists = collect($foreignKeys)->contains(function ($foreignKey) {
                    return in_array('status', $foreignKey->getLocalColumns());
                });

                // Drop the foreign key if it exists
                if ($statusForeignKeyExists) {
                    $table->dropForeign(['status']);
                }

                // Drop the column
                $table->dropColumn('status');
            }

            // Add the new column
            $table->foreignId('status_id')->nullable()->after('active')->constrained('constants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('objectives', function (Blueprint $table) {
            $table->dropForeign(['objective_type_id']);
            $table->dropColumn('objective_type_id');
        });
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['objective_type_id']);
            $table->dropColumn('objective_type_id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['objective_type_id']);
            $table->dropColumn('objective_type_id');
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
