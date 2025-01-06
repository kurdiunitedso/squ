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
        Schema::table('item_costs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('client_id');


        });
        Schema::table('item_costs', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained('client_trillions');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_costs', function (Blueprint $table) {
            //
        });
    }
};
