<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('constants', function (Blueprint $table) {
            $table->string('constant_name', 255)->nullable()->after('field');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('constants', function (Blueprint $table) {
            $table->dropColumn('constant_name');
        });
    }
};
