<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('active')->default(1);
            $table->integer('status_id')->nullable();
            $table->unsignedBigInteger('claim_id')->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('notes', 1000)->nullable();
            $table->double('cost', 8, 2)->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('claim_id', 'claim_items_claim_id_foreign')->references('id')->on('claims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_items');
    }
}
