<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeWhoursEmployeeWhoursCreateUserForeignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_whours', function (Blueprint $table) {
            $table->foreign('create_user', 'employee_whours_create_user_foreign')->references('id')->on('users');
            $table->foreign('update_id', 'employee_whours_update_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_whours', function(Blueprint $table){
            $table->dropForeign('employee_whours_create_user_foreign');
            $table->dropForeign('employee_whours_update_id_foreign');
        });
    }
}
