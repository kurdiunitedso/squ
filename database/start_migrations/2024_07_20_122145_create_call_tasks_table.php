<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('call_id')->nullable();
            $table->unsignedBigInteger('task_status')->nullable();
            $table->unsignedBigInteger('task_action')->nullable();
            $table->string('task_notes', 1000)->nullable();
            $table->unsignedBigInteger('task_urgency')->nullable();
            $table->unsignedBigInteger('task_employee')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('call_id', 'call_tasks_call_id_foreign')->references('id')->on('client_call_actions');
            $table->foreign('task_action', 'call_tasks_task_action_foreign')->references('id')->on('constants');
            $table->foreign('task_employee', 'call_tasks_task_employee_foreign')->references('id')->on('users');
            $table->foreign('task_status', 'call_tasks_task_status_foreign')->references('id')->on('constants');
            $table->foreign('task_urgency', 'call_tasks_task_urgency_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_tasks');
    }
}
