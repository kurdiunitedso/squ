<?php

use App\Models\ProgramPageQuestion;
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
        Schema::create(ProgramPageQuestion::ui['table'], function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_page_id')->constrained()->onDelete('cascade');
            $table->json('question');
            $table->string('type');
            $table->json('options')->nullable();
            $table->integer('score')->default(0);
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
        Schema::dropIfExists(ProgramPageQuestion::ui['table']);
    }
};
