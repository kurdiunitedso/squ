<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 800)->nullable();
            $table->unsignedBigInteger('restaurant_branch_id');
            $table->integer('price');
            $table->integer('preparation_time');
            $table->unsignedBigInteger('status');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('restaurant_id');
            
            $table->foreign('restaurant_branch_id', 'restaurant_items_restaurant_branch_id_foreign')->references('id')->on('restaurant_branches');
            $table->foreign('restaurant_id', 'restaurant_items_restaurant_id_foreign')->references('id')->on('restaurants');
            $table->foreign('status', 'restaurant_items_status_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_items');
    }
}
