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
        Schema::create('marketing_agency_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('fax')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('marketing_agency_id')->nullable();
            $table->unsignedBigInteger('title')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

            $table->foreign('branch_id', 'marketing_agency_teams_branch_id_foreign')->references('id')->on('marketing_agency_branches');
            $table->foreign('city_id', 'marketing_agency_teams_city_id_foreign')->references('id')->on('cities');
            $table->foreign('department_id', 'marketing_agency_teams_department_id_foreign')->references('id')->on('constants');
            $table->foreign('marketing_agency_id', 'marketing_agency_teams_marketing_agency_id_foreign')->references('id')->on('marketing_agencies');
            $table->foreign('title', 'marketing_agency_teams_title_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_agency_teams');
    }
};
