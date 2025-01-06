<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompaniesInsuranceCompaniesBranchIdForeignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurance_companies', function (Blueprint $table) {
            $table->foreign('branch_id', 'insurance_companies_branch_id_foreign')->references('id')->on('insurance_company_branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurance_companies', function(Blueprint $table){
            $table->dropForeign('insurance_companies_branch_id_foreign');
        });
    }
}
