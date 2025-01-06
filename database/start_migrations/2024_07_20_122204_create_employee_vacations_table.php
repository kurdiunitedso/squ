<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_vacations', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->integer('deptno')->default(1);
            $table->integer('type')->nullable();
            $table->date('from_date');
            $table->date('to_date');
            $table->string('reason', 2000)->nullable();
            $table->integer('status')->default(15);
            $table->integer('active')->default(1);
            $table->dateTime('deleted_at')->nullable();
            $table->string('address', 2000)->nullable();
            $table->string('contact_no', 2000)->nullable();
            $table->string('comment', 3000)->nullable();
            $table->integer('submit_by')->nullable();
            $table->dateTime('submit_date')->nullable();
            $table->string('days', 200)->nullable();
            $table->integer('next_approval')->nullable();
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('leaves')->default(0);
            $table->float('balance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_vacations');
    }
}
