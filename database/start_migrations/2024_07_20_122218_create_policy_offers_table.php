<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('insurance_company_id')->nullable();
            $table->integer('work_transport')->default(0);
            $table->integer('has_accidents')->default(0);
            $table->integer('last_accident_year')->nullable();
            $table->double('last_accident_cost', 8, 2)->nullable();
            $table->string('accident_desc')->nullable();
            $table->integer('is_mortgaged')->default(0);
            $table->integer('mortgaged_type')->nullable();
            $table->string('mortgaged_name')->nullable();
            $table->string('source')->nullable();
            $table->date('insurance_start_date')->nullable();
            $table->date('insurance_end_date')->nullable();
            $table->date('policy_id')->nullable();
            $table->string('details')->nullable();
            $table->integer('drivers_under_24')->default(0);
            $table->integer('active')->default(1);
            $table->integer('status_id')->nullable();
            $table->double('offer_cost', 8, 2)->nullable();
            $table->double('offer_approved_cost', 8, 2)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('captin_id')->nullable();
            $table->unsignedBigInteger('policyOffer_type')->nullable();
            
            $table->foreign('captin_id', 'policy_offers_captin_id_foreign')->references('id')->on('captins');
            $table->foreign('insurance_company_id', 'policy_offers_insurance_company_id_foreign')->references('id')->on('constants');
            $table->foreign('policyOffer_type', 'policy_offers_policyoffer_type_foreign')->references('id')->on('constants');
            $table->foreign('user_id', 'policy_offers_user_id_foreign')->references('id')->on('users');
            $table->foreign('vehicle_id', 'policy_offers_vehicle_id_foreign')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_offers');
    }
}
