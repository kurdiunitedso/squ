<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_branches', function (Blueprint $table) {
            $table->id();
            $table->string('address', 800)->nullable();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('city_id');
            $table->string('telephone', 15);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('city_id', 'restaurant_branches_city_id_foreign')->references('id')->on('cities');
            $table->foreign('restaurant_id', 'restaurant_branches_restaurant_id_foreign')->references('id')->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_branches');
    }
}
