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
        Schema::create('item_costs', function (Blueprint $table) {
            $table->softDeletes();
            $table->timestamps();
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->foreignId('client_id')->nullable()->constrained('items');
            $table->foreignId('facility_id')->nullable()->constrained('items');
            $table->float('discount')->nullable();
            $table->float('qty')->nullable();
            $table->float('cost');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_costs');

    }
};
