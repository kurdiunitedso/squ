<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_histories', function (Blueprint $table) {
            $table->id();
            $table->string('body', 5000)->nullable();
            $table->string('fromMe', 10)->nullable();
            $table->string('self', 10)->nullable();
            $table->string('isForwarded', 10)->nullable();
            $table->string('author', 50)->nullable();
            $table->string('time', 50)->nullable();
            $table->string('chatId', 50)->nullable();
            $table->string('messageNumber', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('senderName', 100)->nullable();
            $table->string('caption', 100)->nullable();
            $table->string('quotedMsgBody', 100)->nullable();
            $table->string('quotedMsgId', 100)->nullable();
            $table->string('quotedMsgType', 100)->nullable();
            $table->string('metadata', 900)->nullable();
            $table->string('ack', 100)->nullable();
            $table->string('chatName', 100)->nullable();
            $table->string('idd', 1000)->default('0');
            $table->string('instance_type', 100)->nullable();
            $table->string('instance_id', 100)->nullable();
            $table->timestamps();
            $table->string('instance_name', 100)->nullable();
            $table->string('wid', 1000)->nullable();
            
            $table->index(['instance_type', 'instance_id'], 'whatsapp_histories_instance_type_instance_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_histories');
    }
}
