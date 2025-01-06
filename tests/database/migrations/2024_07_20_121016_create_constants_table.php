<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->string('module')->index('constants_module_index');
            $table->string('field')->index('constants_field_index');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('name_ar', 100)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            
            $table->foreign('parent_id', 'constants_parent_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constants');
    }
}
