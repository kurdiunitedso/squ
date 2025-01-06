<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('captin_id');
            $table->string('to', 15);
            $table->text('text');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('channel')->nullable();
            
            $table->foreign('captin_id', 'short_messages_captin_id_foreign')->references('id')->on('captins');
            $table->foreign('type_id', 'short_messages_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_messages');
    }
}
