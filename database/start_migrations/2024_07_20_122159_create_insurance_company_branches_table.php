<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompanyBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_company_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('fax')->nullable();
            $table->string('floor')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('insurance_company_id')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('city_id', 'insurance_company_branches_city_id_foreign')->references('id')->on('cities');
            $table->foreign('insurance_company_id', 'insurance_company_branches_insurance_company_id_foreign')->references('id')->on('insurance_companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_company_branches');
    }
}
