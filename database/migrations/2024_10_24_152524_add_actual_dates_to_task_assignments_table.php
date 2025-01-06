<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->integer('actual_days')->nullable();
        });
    }

    public function down()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->dropColumn(['actual_start_date', 'actual_end_date', 'actual_days']);
        });
    }
};
