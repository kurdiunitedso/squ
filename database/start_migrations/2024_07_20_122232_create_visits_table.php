<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_request_id')->nullable();
            $table->date('visit_date')->nullable();
            $table->time('visit_time')->nullable();
            $table->unsignedBigInteger('period')->nullable();
            $table->unsignedBigInteger('visit_type')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->integer('rate_company')->default(0);
            $table->integer('rate_captin')->default(0);
            $table->string('visit_name')->default('0');
            $table->string('telephone')->default('0');
            $table->unsignedBigInteger('employee')->nullable();
            $table->string('details', 1000)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->text('ticket_answer')->nullable();
            $table->string('visit_number')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('visit_category')->nullable();
            $table->date('last_date')->nullable();
            $table->unsignedBigInteger('purpose')->nullable();
            $table->unsignedBigInteger('department')->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('call_id')->nullable();
            
            $table->foreign('city_id', 'visits_city_id_foreign')->references('id')->on('cities');
            $table->foreign('employee', 'visits_employee_foreign')->references('id')->on('users');
            $table->foreign('period', 'visits_period_foreign')->references('id')->on('constants');
            $table->foreign('status', 'visits_status_foreign')->references('id')->on('constants');
            $table->foreign('visit_category', 'visits_visit_category_foreign')->references('id')->on('constants');
            $table->foreign('visit_request_id', 'visits_visit_request_id_foreign')->references('id')->on('visit_requests');
            $table->foreign('visit_type', 'visits_visit_type_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
