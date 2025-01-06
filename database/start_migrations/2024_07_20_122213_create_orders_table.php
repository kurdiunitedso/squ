<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('captin_id')->nullable();
            $table->string('telephone')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('type')->nullable();
            $table->string('restaurant_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('order_no')->nullable();
            $table->string('client_name')->nullable();
            $table->string('captin_name')->nullable();
            $table->string('captin_mobile')->nullable();
            $table->string('client_mobile1')->nullable();
            $table->string('client_mobile2')->nullable();
            $table->string('city_name')->nullable();
            $table->string('sub_destination')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->date('order_create_date')->nullable();
            $table->time('order_create_time')->nullable();
            $table->string('expected_prep_time')->nullable();
            $table->dateTime('pickup_time')->nullable();
            $table->text('details')->nullable();
            $table->string('delivery_status')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->double('grand_total', 8, 2)->default(0.00);
            
            $table->foreign('captin_id', 'orders_captin_id_foreign')->references('id')->on('captins');
            $table->foreign('city_id', 'orders_city_id_foreign')->references('id')->on('cities');
            $table->foreign('client_id', 'orders_client_id_foreign')->references('id')->on('clients');
            $table->foreign('restaurant_id', 'orders_restaurant_id_foreign')->references('id')->on('restaurants');
            $table->foreign('status', 'orders_status_foreign')->references('id')->on('constants');
            $table->foreign('type', 'orders_type_foreign')->references('id')->on('constants');
            $table->foreign('user_id', 'orders_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
