<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('program_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_page_id')->constrained()->onDelete('cascade');
            $table->json('name');
            $table->string('type'); // text, textarea, select, checkbox, tags, repeater, file
            $table->json('options')->nullable();
            $table->json('scores')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_questions');
    }
};
