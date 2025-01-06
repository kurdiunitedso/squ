<?php

use App\Models\Project;
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
        Schema::table(Project::ui['table'], function (Blueprint $table) {
            $table->foreignId('item_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Project::ui['table'], function (Blueprint $table) {
            $table->foreignId('item_id')->nullable(false)->change();
        });
    }
};
