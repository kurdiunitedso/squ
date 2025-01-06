<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->boolean('wheels')->change();
            $table->boolean('active')->change();
            $table->boolean('has_agency')->change();
            $table->boolean('intersted')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('wheels')->change();
            $table->integer('active')->change();
            $table->integer('has_agency')->change();
            $table->integer('intersted')->change();
        });
    }
};
