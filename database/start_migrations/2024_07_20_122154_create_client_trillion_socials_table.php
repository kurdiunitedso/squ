<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTrillionSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_trillion_socials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_trillion_id')->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->integer('active')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('social_user_name')->nullable();
            $table->string('social_password')->nullable();
            $table->double('likes', 8, 2)->nullable();
            $table->dateTime('last_update_date')->nullable();
            
            $table->foreign('client_trillion_id', 'client_trillion_socials_client_trillion_id_foreign')->references('id')->on('client_trillions');
            $table->foreign('platform_id', 'client_trillion_socials_platform_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_trillion_socials');
    }
}
