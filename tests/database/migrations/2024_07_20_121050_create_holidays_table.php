<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->timestamp('create_date')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('type')->default(0);
            $table->integer('active')->default(1);
            $table->integer('status')->default(15);
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('days')->default(0);
            $table->string('notes', 1000)->nullable();
            $table->string('name', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
