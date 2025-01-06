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
        Schema::table('attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('attachment_type_id')->nullable()->change();
            $table->string('file_path')->nullable()->after('attachment_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('attachment_type_id')->nullable(false)->change();
            $table->dropColumn(['file_path']);
        });
    }
};
