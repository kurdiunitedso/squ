<?php

use App\Models\Employee;
use App\Models\Project;
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
        Schema::create('project_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId(Employee::ui['_id'])->constrained(Employee::ui['table']);
            $table->foreignId(Project::ui['_id'])->constrained(Project::ui['table']);
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['project_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_employees');
    }
};
