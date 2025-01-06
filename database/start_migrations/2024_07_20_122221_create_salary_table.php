<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->timestamp('create_date')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('type')->default(0);
            $table->integer('status')->default(15);
            $table->integer('employee_id')->default(0);
            $table->integer('month')->default(0);
            $table->integer('year')->default(0);
            $table->integer('active')->default(1);
            $table->double('total_salary', 8, 2)->default(0.00);
            $table->double('total_allowance', 8, 2)->default(0.00);
            $table->double('total_deduction', 8, 2)->default(0.00);
            $table->double('working_hours', 8, 2)->default(0.00);
            $table->double('schedule_hours', 8, 2)->default(0.00);
            $table->double('hour_rate', 8, 2)->default(0.00);
            $table->string('employee_name', 500)->nullable();
            $table->string('employee_no', 100)->nullable();
            $table->string('employee_sid', 100)->nullable();
            $table->string('department', 500)->nullable();
            $table->text('allowance')->nullable();
            $table->text('deduction')->nullable();
            $table->string('notes', 1000)->nullable();
            $table->string('bank_iban', 500)->nullable();
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
        Schema::dropIfExists('salary');
    }
}
