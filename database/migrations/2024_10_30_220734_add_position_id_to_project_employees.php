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
        Schema::table('project_employees', function (Blueprint $table) {
            // Add position_id column after employee_id
            $table->foreignId('position_id')->nullable()->after('project_id')->constrained(Constant::ui['table']);
            // Add order column for sorting if it doesn't exist
            if (!Schema::hasColumn('project_employees', 'order')) {
                $table->integer('order')->default(0)->after('position_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_employees', function (Blueprint $table) {
            // Remove foreign key constraint first
            $table->dropForeign(['position_id']);

            // Then remove the column
            $table->dropColumn('position_id');

            // Drop order column if it was added in this migration
            if (Schema::hasColumn('project_employees', 'order')) {
                $table->dropColumn('order');
            }
        });
    }
};
