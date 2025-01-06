<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('notes')->nullable();
            $table->string('title')->nullable();
            $table->date('claim_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('claim_no')->nullable();
            $table->integer('active')->default(1);
            $table->integer('status_id')->nullable();
            $table->integer('type')->nullable();
            $table->double('cost', 8, 2)->nullable();
            $table->double('discount', 8, 2)->nullable();
            $table->double('total_cost', 8, 2)->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('client_id', 'claims_client_id_foreign')->references('id')->on('client_trillions');
            $table->foreign('project_id', 'claims_project_id_foreign')->references('id')->on('client_trillion_socials');
            $table->foreign('user_id', 'claims_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claims');
    }
}
