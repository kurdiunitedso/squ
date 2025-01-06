<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSmsNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_sms_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('mobile', 100);
            $table->string('gateway', 100);
            $table->string('message', 1000);
            $table->integer('sms_count');
            $table->string('sender_type');
            $table->unsignedBigInteger('sender_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('module')->nullable();
            $table->integer('module_id')->default(0);
            $table->string('channel')->nullable();
            
            $table->index(['sender_type', 'sender_id'], 'system_sms_notifications_sender_type_sender_id_index');
            $table->foreign('type_id', 'system_sms_notifications_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_sms_notifications');
    }
}
