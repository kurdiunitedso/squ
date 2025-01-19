<?php

use App\Models\Constant;
use App\Models\WebsiteSection;
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
        Schema::create(WebsiteSection::ui['table'], function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('type_id')->nullable()->constrained(Constant::ui['table']);
            $table->text('description')->nullable();

            $table->string('image')->nullable();
            $table->boolean('active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(WebsiteSection::ui['table']);
    }
};
