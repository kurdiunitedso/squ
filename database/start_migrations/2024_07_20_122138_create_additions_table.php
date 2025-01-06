<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_item_id')->nullable();
            $table->unsignedBigInteger('addition_type')->nullable();
            $table->unsignedBigInteger('addition_category')->nullable();
            $table->string('name');
            $table->double('price', 8, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('addition_category', 'additions_addition_category_foreign')->references('id')->on('constants');
            $table->foreign('addition_type', 'additions_addition_type_foreign')->references('id')->on('constants');
            $table->foreign('restaurant_item_id', 'additions_restaurant_item_id_foreign')->references('id')->on('restaurant_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additions');
    }
}
