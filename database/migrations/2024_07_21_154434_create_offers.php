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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('wheels')->nullable();
            $table->integer('active')->nullable();

            $table->string('duration')->nullable();
            $table->float('cost')->nullable();
            $table->float('discount')->nullable();
            $table->float('total_cost')->nullable();


            $table->softDeletes();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('type_id')->nullable()->constrained('constants');
            $table->foreignId('visit_id')->nullable()->constrained('visits');
            $table->foreignId('lead_id')->nullable()->constrained('leads');
            $table->foreignId('facility_id')->nullable()->constrained('facilities');
            $table->foreignId('status')->nullable()->constrained('constants');
            $table->foreignId('offer_type')->nullable()->constrained('constants');
        });
        Schema::table('leads', function (Blueprint $table) {
           // $table->dropColumn('offer_id');
            $table->foreignId('offer_id')->nullable()->constrained('offers');
        });
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('description')->nullable();
            $table->float('cost')->nullable();
            $table->softDeletes();
        });
        Schema::create('offer_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('description')->nullable();
            $table->float('cost')->nullable();
            $table->float('discount')->nullable();
            $table->float('total_cost')->nullable();

            $table->softDeletes();
            $table->foreignId('offer_id')->nullable()->constrained('offers');
            $table->foreignId('item_id')->nullable()->constrained('items');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['offer_id']);
            $table->dropColumn('offer_id');
        });
        Schema::dropIfExists('offer_items');
        Schema::dropIfExists('items');
        Schema::dropIfExists('offers');

    }
};
