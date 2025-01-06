<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_roll', function (Blueprint $table) {
            $table->id();
            $table->timestamp('create_date')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('type')->default(0);
            $table->integer('category')->default(0);
            $table->integer('payment_type')->default(0);
            $table->integer('active')->default(1);
            $table->integer('status')->default(15);
            $table->double('amount', 8, 2)->default(0.00);
            $table->integer('employee_id');
            $table->string('notes', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_roll');
    }
}
