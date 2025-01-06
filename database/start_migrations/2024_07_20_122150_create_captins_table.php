<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaptinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captins', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 200);
            $table->string('name', 100);
            $table->string('name_en', 100)->nullable();
            $table->string('address', 200)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('assign_city_id')->nullable();
            $table->string('mobile1', 15)->nullable();
            $table->string('mobile2', 15)->nullable();
            $table->unsignedBigInteger('degree')->nullable();
            $table->integer('previous_experience_delivery')->default(0);
            $table->string('company_name', 100)->nullable();
            $table->string('current_work', 100)->nullable();
            $table->string('reference_name', 200)->nullable();
            $table->date('reference_dob')->nullable();
            $table->string('reference_mobile1', 15)->nullable();
            $table->string('reference_mobile2', 15)->nullable();
            $table->unsignedBigInteger('reference_city')->nullable();
            $table->string('reference_relative', 100)->nullable();
            $table->unsignedBigInteger('vehicle_type')->nullable();
            $table->string('vehicle_no', 200)->nullable();
            $table->integer('vehicle_year')->default(0);
            $table->unsignedBigInteger('fuel_type')->nullable();
            $table->integer('sign_permission')->nullable();
            $table->integer('has_insurance')->default(0);
            $table->unsignedBigInteger('insurance_company')->nullable();
            $table->unsignedBigInteger('insurance_type')->nullable();
            $table->date('policy_start')->nullable();
            $table->date('policy_expire')->nullable();
            $table->string('policy_no')->nullable();
            $table->unsignedBigInteger('policy_code')->nullable();
            $table->unsignedBigInteger('policy_degree')->nullable();
            $table->string('captin_id', 100)->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->string('promissory', 200)->nullable();
            $table->string('reference_id', 200)->nullable();
            $table->string('vehicle_model', 200)->nullable();
            $table->unsignedBigInteger('motor_cc')->nullable();
            $table->date('license_expire_date')->nullable();
            $table->integer('active')->default(1);
            $table->integer('total_orders')->default(0);
            $table->double('total_commission_cash')->default(0);
            $table->double('total_commission_visa')->default(0);
            $table->date('join_date')->nullable();
            $table->double('total_commission')->default(0);
            $table->string('box_no')->nullable();
            $table->string('name_ar', 100)->nullable();
            $table->string('id_wheel', 100)->nullable();
            $table->unsignedBigInteger('shift')->nullable();
            $table->double('paid', 8, 2)->nullable();
            $table->double('net_paid', 8, 2)->nullable();
            $table->integer('is_current_wrok')->default(0);
            $table->unsignedBigInteger('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('iban')->nullable();
            $table->unsignedBigInteger('payment_method')->nullable();
            $table->unsignedBigInteger('payment_type')->nullable();
            $table->string('benficiary')->nullable();
            $table->date('expire_driver_licenese')->nullable();
            $table->integer('intersted_in_work_insurance')->default(0);
            $table->string('reference_cardno')->nullable();
            $table->string('refrence_address')->nullable();
            $table->double('commission_pm', 8, 2)->nullable();
            $table->double('commission_am', 8, 2)->nullable();
            $table->time('ptime_to')->nullable();
            $table->time('ptime_from')->nullable();
            $table->unsignedBigInteger('work_days')->nullable();
            $table->unsignedBigInteger('work_type')->nullable();
            $table->time('time_to')->nullable();
            $table->time('time_from')->nullable();
            $table->date('last_update_date')->nullable();
            $table->date('last_order_date')->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->date('license_expire_date2')->nullable();
            $table->string('vehicle_model2', 200)->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->integer('license_no')->nullable();
            
            $table->foreign('assign_city_id', 'captins_assign_city_id_foreign')->references('id')->on('cities');
            $table->foreign('bank_name', 'captins_bank_name_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'captins_city_id_foreign')->references('id')->on('cities');
            $table->foreign('degree', 'captins_degree_foreign')->references('id')->on('constants');
            $table->foreign('fuel_type', 'captins_fuel_type_foreign')->references('id')->on('constants');
            $table->foreign('insurance_company', 'captins_insurance_company_foreign')->references('id')->on('constants');
            $table->foreign('insurance_type', 'captins_insurance_type_foreign')->references('id')->on('constants');
            $table->foreign('motor_cc', 'captins_motor_cc_foreign')->references('id')->on('constants');
            $table->foreign('payment_method', 'captins_payment_method_foreign')->references('id')->on('constants');
            $table->foreign('payment_type', 'captins_payment_type_foreign')->references('id')->on('constants');
            $table->foreign('policy_code', 'captins_policy_code_foreign')->references('id')->on('constants');
            $table->foreign('policy_degree', 'captins_policy_degree_foreign')->references('id')->on('constants');
            $table->foreign('reference_city', 'captins_reference_city_foreign')->references('id')->on('cities');
            $table->foreign('shift', 'captins_shift_foreign')->references('id')->on('constants');
            $table->foreign('vehicle_type', 'captins_vehicle_type_foreign')->references('id')->on('constants');
            $table->foreign('work_days', 'captins_work_days_foreign')->references('id')->on('constants');
            $table->foreign('work_type', 'captins_work_type_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('captins');
    }
}
