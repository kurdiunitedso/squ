<?php

use App\Models\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('task_processes', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->after('employee_id')->constrained('users');
            $table->foreignId('type_id')->nullable()->after('user_id')->constrained(Constant::ui['table']);
            $table->string('old_value')->nullable()->after('type_id');
            $table->string('new_value')->nullable()->after('old_value');
        });

        Schema::table('task_assignments', function (Blueprint $table) {
            // Directly modify the existing columns to date type
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_processes', function (Blueprint $table) {
            // Drop foreign key constraints one by one
            $table->dropForeign(['type_id']);
            $table->dropForeign(['user_id']);

            // Drop columns
            $table->dropColumn('type_id');
            $table->dropColumn('user_id');
            $table->dropColumn('old_value');
            $table->dropColumn('new_value');
        });

        Schema::table('task_assignments', function (Blueprint $table) {
            // Change back to timestamp if needed
            $table->timestamp('start_date')->nullable()->change();
            $table->timestamp('end_date')->nullable()->change();
        });
    }
};
