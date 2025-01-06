<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCallActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_call_actions', function (Blueprint $table) {
            $table->id();
            $table->string('telephone', 15);
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('call_option_id');
            $table->integer('call_action')->nullable();
            $table->nullableMorphs('action');
            $table->string('listen')->nullable();
            $table->boolean('status')->default(1);
            $table->string('notes')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_sid')->nullable();
            $table->string('type')->nullable();
            $table->string('call_option')->nullable();
            $table->string('telephone_no')->nullable();
            $table->integer('active')->default(0);
            $table->string('uniqueid', 200)->default('0');
            $table->string('call_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('call_status')->nullable();
            $table->unsignedBigInteger('caller_type')->nullable();
            $table->double('duration', 8, 2)->nullable();
            $table->string('module')->nullable();
            $table->integer('module_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('assign_employee')->nullable();
            $table->unsignedBigInteger('urgency')->nullable();
            $table->unsignedBigInteger('assign_status')->nullable();
            $table->string('client_name_ar')->nullable();
            
            $table->foreign('assign_employee', 'client_call_actions_assign_employee_foreign')->references('id')->on('users');
            $table->foreign('assign_status', 'client_call_actions_assign_status_foreign')->references('id')->on('constants');
            $table->foreign('call_option_id', 'client_call_actions_call_option_id_foreign')->references('id')->on('constants');
            $table->foreign('call_status', 'client_call_actions_call_status_foreign')->references('id')->on('constants');
            $table->foreign('caller_type', 'client_call_actions_caller_type_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'client_call_actions_city_id_foreign')->references('id')->on('cities');
            $table->foreign('employee_id', 'client_call_actions_employee_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_call_actions');
    }
}
