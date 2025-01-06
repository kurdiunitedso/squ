<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('request_name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('telephone', 200)->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('priority')->nullable();
            $table->unsignedBigInteger('purpose')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->string('details', 1000)->nullable();
            $table->unsignedBigInteger('employee')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('ticket_number')->nullable();
            $table->unsignedBigInteger('ticket_type')->nullable();
            $table->dateTime('ticket_date')->nullable();
            $table->text('ticket_answer')->nullable();
            $table->string('selectedTicket')->nullable();
            $table->string('selectedVisit')->nullable();
            $table->string('selectedCalls')->nullable();
            $table->unsignedBigInteger('target')->nullable();
            $table->unsignedBigInteger('destination')->nullable();
            $table->integer('refund')->nullable();
            $table->double('refund_amount', 8, 2)->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('call_id')->nullable();
            $table->unsignedBigInteger('refund_type')->nullable();
            $table->string('selectedOrder')->nullable();
            
            $table->foreign('call_id', 'tickets_call_id_foreign')->references('id')->on('client_call_actions');
            $table->foreign('category', 'tickets_category_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'tickets_city_id_foreign')->references('id')->on('cities');
            $table->foreign('destination', 'tickets_destination_foreign')->references('id')->on('constants');
            $table->foreign('employee', 'tickets_employee_foreign')->references('id')->on('users');
            $table->foreign('priority', 'tickets_priority_foreign')->references('id')->on('constants');
            $table->foreign('purpose', 'tickets_purpose_foreign')->references('id')->on('constants');
            $table->foreign('refund_type', 'tickets_refund_type_foreign')->references('id')->on('constants');
            $table->foreign('status', 'tickets_status_foreign')->references('id')->on('constants');
            $table->foreign('target', 'tickets_target_foreign')->references('id')->on('constants');
            $table->foreign('ticket_type', 'tickets_ticket_type_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
