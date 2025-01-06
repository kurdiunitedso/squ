<?php

use App\Models\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->foreignId('position_id')->nullable()->after('employee_id')->constrained(Constant::ui['table']);
        });
    }

    public function down()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });
    }
};
