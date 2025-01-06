<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemMailNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_mail_notifications', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('type')->default(1);
            $table->integer('status')->default(1);
            $table->integer('active')->default(1);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('deleted_at')->nullable();
            $table->string('subject', 200)->nullable();
            $table->text('message')->nullable();
            $table->string('module', 200)->nullable();
            $table->integer('request_id')->nullable();
            $table->string('attachment', 200)->nullable();
            $table->string('sent_to', 200)->nullable();
            $table->string('sent_by', 200)->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_mail_notifications');
    }
}
