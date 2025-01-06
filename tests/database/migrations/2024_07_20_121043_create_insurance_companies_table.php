<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('fax')->nullable();
            $table->double('comission', 8, 2)->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_branch_no')->nullable();
            $table->string('iban')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('name_en')->nullable();
            $table->double('commission', 8, 2)->nullable();
            
            $table->foreign('bank_name', 'insurance_companies_bank_name_foreign')->references('id')->on('constants');
            $table->foreign('branch_id', 'insurance_companies_branch_id_foreign')->references('id')->on('insurance_company_branches');
            $table->foreign('type_id', 'insurance_companies_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_companies');
    }
}
