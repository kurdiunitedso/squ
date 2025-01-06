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
        Schema::table('claim_items', function (Blueprint $table) {
            $table->foreignId('month')->nullable()->constrained('constants');
            $table->integer('year')->nullable();
            $table->float('total_cost')->nullable();
            $table->float('discount')->nullable();
         /*   $table->text('notes')->nullable();*/
            $table->integer('item_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claim_items', function (Blueprint $table) {
            //
        });
    }
};
