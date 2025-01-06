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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('facility_id', 50)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('items_no')->nullable()->default(0);
            $table->integer('average_preparation_time')->nullable()->nullable()->default(0);
            $table->integer('daily_orders_in_no')->nullable()->default(0);
            $table->integer('daily_orders_out_no')->nullable()->default(0);
            $table->integer('has_call_center')->default(0);
            $table->integer('need_internal_call_sys')->default(0);
            $table->integer('has_pos')->default(0);
            $table->integer('has_branch')->default(0);
            $table->unsignedBigInteger('pos_type')->nullable();
            $table->integer('annual_subscription')->default(0);
            $table->integer('os_type')->nullable();
            $table->integer('sys_satisfaction_rate')->nullable();
            $table->string('telephone', 15)->nullable();
            $table->string('facebook_address', 200)->nullable();
            $table->string('instagram_address', 200)->nullable();
            $table->string('tiktok_address', 200)->nullable();
            $table->string('fax', 15)->nullable();
            $table->integer('active')->default(1);
            $table->integer('has_marketing')->default(0);
            $table->string('marketing_rep_name', 200)->nullable();
            $table->string('marketing_rep_co_name', 200)->nullable();
            $table->string('pay_to_marketing_agent_amount', 200)->nullable();
            $table->unsignedBigInteger('bank_name')->nullable();
            $table->unsignedBigInteger('bank_branch')->nullable()->index('facilities_bank_branch_foreign');
            $table->string('iban', 200)->nullable();
            $table->string('visa', 200)->nullable();
            $table->string('cash', 200)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('payment_type')->nullable();
            $table->integer('has_marketing_center')->nullable()->default(0);
            $table->integer('commission_visa')->nullable();
            $table->integer('commission_cash')->nullable();
            $table->integer('total_orders')->nullable();
            $table->integer('total_sales_cash')->nullable();
            $table->integer('total_sales_visa')->nullable();
            $table->date('join_date')->nullable();
            $table->integer('has_wheels_b2b')->nullable();
            $table->integer('has_wheels_bot')->nullable();
            $table->integer('has_wheels_now')->nullable();
            $table->string('id_wheel', 100)->nullable();
            $table->double('paid', 8, 2)->nullable();
            $table->double('net_paid', 8, 2)->nullable();
            $table->string('name_en')->nullable();
            $table->string('benficiary')->nullable();
            $table->string('has_box')->nullable();
            $table->string('box_no')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('branch')->nullable();
            $table->unsignedBigInteger('printer_type')->nullable();
            $table->integer('interst_to_market')->nullable();
            $table->string('printer_sn')->nullable();

            $table->foreign('bank_name', 'facilities_bank_name_foreign')->references('id')->on('constants');
            $table->foreign('city_id', 'facilities_city_id_foreign')->references('id')->on('cities');
            $table->foreign('country_id', 'facilities_country_id_foreign')->references('id')->on('countries');
            $table->foreign('payment_type', 'facilities_payment_type_foreign')->references('id')->on('constants');
            $table->foreign('pos_type', 'facilities_pos_type_foreign')->references('id')->on('constants');
            $table->foreign('printer_type', 'facilities_printer_type_foreign')->references('id')->on('constants');
            $table->foreign('type_id', 'facilities_type_id_foreign')->references('id')->on('constants');
            $table->foreign('category_id', 'facilities_category_id_foreign')->references('id')->on('constants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
