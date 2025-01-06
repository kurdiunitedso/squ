<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->string('email')->unique('users_email_unique');
            $table->string('mobile', 15);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(0);
            $table->dateTime('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('branch_id')->nullable();
            $table->unsignedBigInteger('checkin')->nullable();
            $table->integer('isemployee')->default(0);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('cities')->nullable();
            $table->string('position')->nullable();
            $table->string('name_ar', 200)->nullable();
            
            $table->foreign('checkin', 'users_checkin_foreign')->references('id')->on('employee_whours');
            $table->foreign('department_id', 'users_department_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
