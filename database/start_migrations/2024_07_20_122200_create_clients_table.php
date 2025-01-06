<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->string('mobile')->nullable();
            $table->string('name')->nullable();
            $table->string('client_id')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('last_login_date')->nullable();
            $table->integer('orders_box')->nullable();
            $table->integer('orders_bot')->nullable();
            $table->integer('orders_now')->nullable();
            $table->dateTime('last_orders_box')->nullable();
            $table->dateTime('last_orders_bot')->nullable();
            $table->dateTime('last_orders_now')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('active')->nullable();
            $table->string('telephone', 100)->nullable();
            $table->unsignedBigInteger('assign_city_id')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('call_id')->nullable();
            $table->unsignedBigInteger('insurance_company_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            
            $table->foreign('assign_city_id', 'clients_assign_city_id_foreign')->references('id')->on('cities');
            $table->foreign('call_id', 'clients_call_id_foreign')->references('id')->on('client_call_actions');
            $table->foreign('category', 'clients_category_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'clients_city_id_foreign')->references('id')->on('cities');
            $table->foreign('insurance_company_id', 'clients_insurance_company_id_foreign')->references('id')->on('insurance_companies');
            $table->foreign('status', 'clients_status_foreign')->references('id')->on('constants');
            $table->foreign('type_id', 'clients_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
