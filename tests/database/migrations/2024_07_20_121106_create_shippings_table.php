<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->unsignedBigInteger('restaurant_branch_id')->nullable();
            $table->string('name');
            $table->double('price', 8, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('city_id', 'shippings_city_id_foreign')->references('id')->on('cities');
            $table->foreign('restaurant_branch_id', 'shippings_restaurant_branch_id_foreign')->references('id')->on('restaurant_branches');
            $table->foreign('restaurant_id', 'shippings_restaurant_id_foreign')->references('id')->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
