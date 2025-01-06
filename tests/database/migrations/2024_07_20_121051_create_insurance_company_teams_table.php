<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompanyTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_company_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('fax')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('insurance_company_id')->nullable();
            $table->unsignedBigInteger('title')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            
            $table->foreign('branch_id', 'insurance_company_teams_branch_id_foreign')->references('id')->on('insurance_company_branches');
            $table->foreign('city_id', 'insurance_company_teams_city_id_foreign')->references('id')->on('cities');
            $table->foreign('department_id', 'insurance_company_teams_department_id_foreign')->references('id')->on('constants');
            $table->foreign('insurance_company_id', 'insurance_company_teams_insurance_company_id_foreign')->references('id')->on('insurance_companies');
            $table->foreign('title', 'insurance_company_teams_title_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_company_teams');
    }
}
