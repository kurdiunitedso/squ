<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversUnder24Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_under_24', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('driver_name')->nullable();
            $table->string('driver_id')->nullable();
            $table->date('dob')->nullable();
            $table->string('telephone', 200)->nullable();
            $table->string('address')->nullable();
            $table->string('license_no')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('email')->nullable();
            
            $table->foreign('user_id', 'drivers_under_24_user_id_foreign')->references('id')->on('users');
            $table->foreign('vehicle_id', 'drivers_under_24_vehicle_id_foreign')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers_under_24');
    }
}
