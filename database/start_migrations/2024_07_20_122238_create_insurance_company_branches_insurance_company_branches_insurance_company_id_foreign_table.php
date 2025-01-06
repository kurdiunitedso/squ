<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompanyBranchesInsuranceCompanyBranchesInsuranceCompanyIdForeignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurance_company_branches', function (Blueprint $table) {
           // $table->foreign('insurance_company_id', 'insurance_company_branches_insurance_company_id_foreign')->references('id')->on('insurance_companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurance_company_branches', function(Blueprint $table){
            $table->dropForeign('insurance_company_branches_insurance_company_id_foreign');
        });
    }
}
