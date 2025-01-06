<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdrLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdr_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('date');
            $table->string('from');
            $table->string('to');
            $table->integer('duration');
            $table->string('call_status', 200)->nullable();
            $table->string('call_type', 200)->nullable();
            $table->string('record_file_name');
            $table->timestamps();
            $table->integer('history')->default(0);
            $table->string('uniqueid', 200)->nullable()->index('cdr_logs_uniqueid_index');
            $table->string('record_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdr_logs');
    }
}
