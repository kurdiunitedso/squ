<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTrillionTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_trillion_teams', function (Blueprint $table) {
            $table->id();
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('client_trillion_id')->nullable();
            $table->string('telephone')->nullable();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_h')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->integer('active')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('title_id')->nullable();
            
            $table->foreign('client_trillion_id', 'client_trillion_teams_client_trillion_id_foreign')->references('id')->on('client_trillions');
            $table->foreign('department_id', 'client_trillion_teams_department_id_foreign')->references('id')->on('constants');
            $table->foreign('schedule_id', 'client_trillion_teams_schedule_id_foreign')->references('id')->on('constants');
            $table->foreign('title_id', 'client_trillion_teams_title_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_trillion_teams');
    }
}
