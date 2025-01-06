<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(15);
            $table->integer('active')->default(1);
            $table->integer('next_approval')->default(5);
            $table->dateTime('create_user')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('type')->nullable();
            $table->integer('employee_id')->nullable();
            $table->time('time_from');
            $table->time('time_to');
            $table->integer('day_name');
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->date('valid_from')->default('1970-01-01');
            $table->date('valid_to')->default('1970-01-01');
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_schedule');
    }
}
