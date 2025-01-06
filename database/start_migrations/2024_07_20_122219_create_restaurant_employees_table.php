<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 800)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('restaurant_branch_id')->nullable();
            $table->string('mobile', 15);
            $table->string('email', 50)->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->string('title', 200)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('restaurant_id');
            $table->string('whatsapp')->nullable();
            
            $table->foreign('city_id', 'restaurant_employees_city_id_foreign')->references('id')->on('cities');
            $table->foreign('restaurant_branch_id', 'restaurant_employees_restaurant_branch_id_foreign')->references('id')->on('restaurant_branches');
            $table->foreign('restaurant_id', 'restaurant_employees_restaurant_id_foreign')->references('id')->on('restaurants');
            $table->foreign('status', 'restaurant_employees_status_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_employees');
    }
}
