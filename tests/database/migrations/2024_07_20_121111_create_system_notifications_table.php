<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->boolean('status')->default(1);
            $table->boolean('active')->default(1);
            $table->string('subject', 200)->nullable();
            $table->string('message', 2000)->nullable();
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->string('attachment', 200)->nullable();
            $table->unsignedBigInteger('sent_by');
            $table->unsignedBigInteger('sent_to')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->index(['notifiable_type', 'notifiable_id'], 'system_notifications_notifiable_type_notifiable_id_index');
            $table->foreign('sent_by', 'system_notifications_sent_by_foreign')->references('id')->on('users');
            $table->foreign('type_id', 'system_notifications_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_notifications');
    }
}
