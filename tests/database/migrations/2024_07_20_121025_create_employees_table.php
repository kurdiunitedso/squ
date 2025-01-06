<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('gender')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->integer('active')->default(1);
            $table->double('sick', 8, 2)->default(0.00);
            $table->double('salary', 8, 2)->default(0.00);
            $table->double('leaves', 8, 2)->default(0.00);
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('sid')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_account')->nullable();
            $table->unsignedBigInteger('job_title')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->double('balance', 8, 2)->default(0.00);
            $table->double('max_annual_leaves', 8, 2)->default(28.00);
            $table->double('max_annual_sick', 8, 2)->default(28.00);
            $table->double('max_sick', 8, 2)->default(14.00);
            $table->double('max_leaves', 8, 2)->default(14.00);
            $table->double('increment', 8, 2)->default(0.00);
            $table->double('evaluation', 8, 2)->default(0.00);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('title')->nullable();
            $table->string('empno')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->date('dob')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->unique('user_id_unique');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->dateTime('employment_date')->useCurrent();
            
            $table->foreign('city_id', 'employees_city_id_foreign')->references('id')->on('cities');
            $table->foreign('department_id', 'employees_department_id_foreign')->references('id')->on('constants');
            $table->foreign('gender', 'employees_gender_foreign')->references('id')->on('constants');
            $table->foreign('job_title', 'employees_job_title_foreign')->references('id')->on('constants');
            $table->foreign('status', 'employees_status_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
