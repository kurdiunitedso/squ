<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortMessageTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_message_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->text('template_text');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('type_id', 'short_message_templates_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_message_templates');
    }
}
