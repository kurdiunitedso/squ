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
        Schema::create('facility_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 800)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('facility_branch_id')->nullable();
            $table->string('mobile', 15);
            $table->string('email', 50)->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->string('title', 200)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('facility_id');
            $table->string('whatsapp')->nullable();

            $table->foreign('city_id', 'facility_employees_city_id_foreign')->references('id')->on('cities');
            $table->foreign('facility_branch_id', 'facility_employees_facility_branch_id_foreign')->references('id')->on('facility_branches');
            $table->foreign('facility_id', 'facility_employees_facility_id_foreign')->references('id')->on('facilities');
            $table->foreign('status', 'facility_employees_status_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_employees');
    }
};
