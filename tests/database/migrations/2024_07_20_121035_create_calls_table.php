<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->enum('call_type', ['incoming_call', 'outgoing_call']);
            $table->unsignedBigInteger('captin_id');
            $table->unsignedBigInteger('call_action_id')->nullable();
            $table->unsignedBigInteger('captin_action_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('next_call')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('call_action_id', 'calls_call_action_id_foreign')->references('id')->on('constants');
            $table->foreign('captin_action_id', 'calls_captin_action_id_foreign')->references('id')->on('constants');
            $table->foreign('captin_id', 'calls_captin_id_foreign')->references('id')->on('captins');
            $table->foreign('user_id', 'calls_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
