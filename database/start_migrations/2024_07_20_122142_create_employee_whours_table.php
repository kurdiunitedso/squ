<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeWhoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_whours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status')->nullable();
            $table->integer('active')->default(1);
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('create_user')->nullable();
            $table->date('work_date')->nullable();
            $table->dateTime('from_time')->nullable();
            $table->dateTime('to_time')->nullable();
            $table->string('notes', 1000)->nullable();
            $table->string('last_ip')->nullable();
            $table->dateTime('update_date')->nullable();
            $table->unsignedBigInteger('update_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

           // $table->foreign('create_user', 'employee_whours_create_user_foreign')->references('id')->on('users');
            $table->foreign('employee_id', 'employee_whours_employee_id_foreign')->references('id')->on('employees');
            $table->foreign('status', 'employee_whours_status_foreign')->references('id')->on('constants');
          //  $table->foreign('update_id', 'employee_whours_update_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_whours');
    }
}
