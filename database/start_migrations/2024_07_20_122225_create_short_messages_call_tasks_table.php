<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortMessagesCallTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_messages_call_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('callTask_id');
            $table->string('to', 15);
            $table->text('text');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('callTask_id', 'short_messages_call_tasks_calltask_id_foreign')->references('id')->on('call_tasks');
            $table->foreign('type_id', 'short_messages_call_tasks_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_messages_call_tasks');
    }
}
