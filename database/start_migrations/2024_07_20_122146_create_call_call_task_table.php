<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallCallTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_call_task', function (Blueprint $table) {
            $table->id();
            $table->enum('call_type', ['incoming_call', 'outgoing_call']);
            $table->unsignedBigInteger('callTask_id');
            $table->unsignedBigInteger('call_action_id')->nullable();
            $table->unsignedBigInteger('callTask_action_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('next_call')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('call_action_id', 'call_call_task_call_action_id_foreign')->references('id')->on('constants');
            $table->foreign('callTask_action_id', 'call_call_task_calltask_action_id_foreign')->references('id')->on('constants');
            $table->foreign('callTask_id', 'call_call_task_calltask_id_foreign')->references('id')->on('call_tasks');
            $table->foreign('user_id', 'call_call_task_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_call_task');
    }
}
