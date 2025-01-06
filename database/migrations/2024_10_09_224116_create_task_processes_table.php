<?php

use App\Models\Employee;
use App\Models\TaskAssignment;
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
        Schema::create('task_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId(TaskAssignment::ui['_id'])->constrained(TaskAssignment::ui['table']);
            $table->foreignId(Employee::ui['_id'])->constrained(Employee::ui['table']);
            $table->longText('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_processes');
    }
};
