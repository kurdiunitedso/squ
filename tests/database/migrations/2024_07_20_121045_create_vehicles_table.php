<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('captin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vehicle_type');
            $table->string('vehicle_no', 200)->nullable();
            $table->unsignedBigInteger('vehicle_model')->nullable();
            $table->integer('vehicle_year')->default(0);
            $table->integer('motor_cc')->nullable();
            $table->unsignedBigInteger('fuel_type')->nullable();
            $table->unsignedBigInteger('box_noo')->nullable();
            $table->integer('sign_permission')->nullable();
            $table->dateTime('policy_expire')->nullable();
            $table->integer('has_insurance')->default(0);
            $table->unsignedBigInteger('insurance_company')->nullable();
            $table->unsignedBigInteger('insurance_type')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('color')->nullable();
            $table->double('cost', 8, 2)->default(0.00);
            $table->string('motor_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->double('weight', 8, 2)->nullable();
            $table->integer('active')->default(1);
            $table->unsignedBigInteger('vehicle_brand')->nullable();
            $table->string('vehicle_details', 1000)->nullable();
            $table->dateTime('license_expire_date2')->nullable();
            $table->string('promissory', 200)->nullable();
            $table->string('vehicle_model2')->nullable();
            $table->string('box_no')->nullable();
            $table->integer('passengers')->nullable();
            $table->integer('is_new')->default(0);
            $table->string('car_details')->nullable();
            
            $table->foreign('box_noo', 'vehicle_box_no_foreign')->references('id')->on('constants');
            $table->foreign('captin_id', 'vehicle_captin_id_foreign')->references('id')->on('captins');
            $table->foreign('fuel_type', 'vehicle_fuel_type_foreign')->references('id')->on('constants');
            $table->foreign('insurance_company', 'vehicle_insurance_company_foreign')->references('id')->on('constants');
            $table->foreign('insurance_type', 'vehicle_insurance_type_foreign')->references('id')->on('constants');
            $table->foreign('user_id', 'vehicle_user_id_foreign')->references('id')->on('users');
            $table->foreign('vehicle_model', 'vehicle_vehicle_model_foreign')->references('id')->on('constants');
            $table->foreign('vehicle_type', 'vehicle_vehicle_type_foreign')->references('id')->on('constants');
            $table->foreign('vehicle_brand', 'vehicles_car_brand_foreign')->references('id')->on('constants');
            $table->foreign('color', 'vehicles_color_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
