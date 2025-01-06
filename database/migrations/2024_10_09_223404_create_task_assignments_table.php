<?php

use App\Models\Constant;
use App\Models\Employee;
use App\Models\Task;
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
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId(Task::ui['_id'])->constrained(Task::ui['table']);
            $table->foreignId(Employee::ui['_id'])->constrained(Employee::ui['table']);
            $table->foreignId('next_employee_id')->nullable()->constrained(Employee::ui['table']);
            $table->foreignId('art_manager_id')->constrained(Employee::ui['table']);
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->foreignId('status_id')->constrained(Constant::ui['table']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assignments');
    }
};
