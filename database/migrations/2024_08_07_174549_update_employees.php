<?php

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
        Schema::table('marketing_agencies', function (Blueprint $table) {
            $table->string('employees')->nullable();
            $table->string('facebook_address')->nullable();
            $table->string('instagram_address')->nullable();
            $table->string('tiktok_address')->nullable();
            $table->string('manager_name')->nullable();
            $table->foreignId('size_id')->nullable()->constrained('constants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketing_agencies', function (Blueprint $table) {
            //
        });
    }
};
