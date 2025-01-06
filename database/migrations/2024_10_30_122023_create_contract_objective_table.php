<?php

use App\Models\Objective;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_objective', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained(Project::ui['table']);
            $table->foreignId('objective_id')->constrained(Objective::ui['table']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id', 'objective_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contract_objective');
    }
};
