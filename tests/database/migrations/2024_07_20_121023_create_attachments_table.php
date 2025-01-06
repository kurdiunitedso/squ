<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attachment_type_id');
            $table->string('file_hash');
            $table->string('attachable_type');
            $table->unsignedBigInteger('attachable_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('file_name');
            $table->string('source')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            
            $table->index(['attachable_type', 'attachable_id'], 'attachments_attachable_type_attachable_id_index');
            $table->foreign('attachment_type_id', 'attachments_attachment_type_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
