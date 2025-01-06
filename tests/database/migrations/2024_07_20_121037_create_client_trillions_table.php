<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTrillionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_trillions', function (Blueprint $table) {
            $table->id();
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_h')->nullable();
            $table->string('registration_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->unsignedBigInteger('company_type')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->unsignedBigInteger('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('iban')->nullable();
            $table->unsignedBigInteger('payment_method')->nullable();
            $table->unsignedBigInteger('payment_type')->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->integer('active')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('benficiary');
            $table->unsignedBigInteger('title_id')->nullable();
            
            $table->foreign('bank_name', 'client_trillions_bank_name_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'client_trillions_city_id_foreign')->references('id')->on('cities');
            $table->foreign('company_type', 'client_trillions_company_type_foreign')->references('id')->on('constants');
            $table->foreign('country_id', 'client_trillions_country_id_foreign')->references('id')->on('countries');
            $table->foreign('payment_method', 'client_trillions_payment_method_foreign')->references('id')->on('constants');
            $table->foreign('payment_type', 'client_trillions_payment_type_foreign')->references('id')->on('constants');
            $table->foreign('title_id', 'client_trillions_title_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_trillions');
    }
}
