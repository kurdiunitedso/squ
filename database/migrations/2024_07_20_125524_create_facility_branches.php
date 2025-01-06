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
        Schema::create('facility_branches', function (Blueprint $table) {
            $table->id();
            $table->string('address', 800)->nullable();
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('city_id');
            $table->string('telephone', 15);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('city_id', 'facility_branches_city_id_foreign')->references('id')->on('cities');
            $table->foreign('facility_id', 'facility_branches_facility_id_foreign')->references('id')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_branches');
    }
};
