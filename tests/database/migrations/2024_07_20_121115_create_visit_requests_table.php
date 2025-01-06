<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('visit_name', 200)->nullable();
            $table->string('mobile', 200)->nullable();
            $table->date('visit_date')->nullable();
            $table->unsignedBigInteger('visit_category')->nullable();
            $table->unsignedBigInteger('priority')->nullable();
            $table->unsignedBigInteger('visit_type')->nullable();
            $table->unsignedBigInteger('purpose')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('requester')->nullable();
            $table->unsignedBigInteger('employee')->nullable();
            $table->string('details', 1000)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->dateTime('last_date')->nullable();
            $table->string('telephone')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('department')->nullable();
            
            $table->foreign('visit_category', 'visit_requests_category_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'visit_requests_city_id_foreign')->references('id')->on('cities');
            $table->foreign('department', 'visit_requests_department_foreign')->references('id')->on('constants');
            $table->foreign('employee', 'visit_requests_employee_foreign')->references('id')->on('users');
            $table->foreign('priority', 'visit_requests_priority_foreign')->references('id')->on('constants');
            $table->foreign('purpose', 'visit_requests_purpose_foreign')->references('id')->on('constants');
            $table->foreign('requester', 'visit_requests_requester_foreign')->references('id')->on('users');
            $table->foreign('status', 'visit_requests_status_foreign')->references('id')->on('constants');
            $table->foreign('visit_type', 'visit_requests_visit_type_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_requests');
    }
}
