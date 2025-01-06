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
    public function up()
    {
        Schema::create('marketing_agency_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('fax')->nullable();
            $table->string('floor')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('marketing_agency_id')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('city_id', 'marketing_agency_branches_city_id_foreign')->references('id')->on('cities');
            $table->foreign('marketing_agency_id', 'marketing_agency_branches_marketing_agency_id_foreign')->references('id')->on('marketing_agencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_agency_branches');
    }
};
