<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Modify existing columns to be nullable
            // $table->foreignId('client_trillion_id')->nullable()->change();
            $table->foreignId('account_manager_id')->nullable()->change();
            $table->foreignId('offer_id')->nullable()->change();
            $table->foreignId('type_id')->nullable()->change();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->text('objectives')->nullable()->change();
            $table->string('duration')->nullable()->change();
            $table->foreignId('status_id')->nullable()->change();
            $table->decimal('total_cost', 10, 2)->nullable()->change();
            $table->decimal('total_discount', 10, 2)->nullable()->change();
            $table->boolean('is_vat')->nullable()->change();
            $table->boolean('approved_by_admin')->nullable()->change();
        });

        Schema::table('contract_items', function (Blueprint $table) {
            // Modify contract items columns to be nullable
            // $table->foreignId('contract_id')->nullable()->change();
            // $table->foreignId('item_id')->nullable()->change();
            // $table->decimal('cost', 10, 2)->nullable()->change();
            // $table->integer('qty')->nullable()->change();
            // $table->decimal('discount', 10, 2)->nullable()->change();
            // $table->decimal('total_cost', 10, 2)->nullable()->change();
            // $table->text('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Reverse changes if needed
            $table->foreignId('client_trillion_id')->nullable(false)->change();
            $table->foreignId('account_manager_id')->nullable(false)->change();
            $table->foreignId('offer_id')->nullable(false)->change();
            $table->foreignId('type_id')->nullable(false)->change();
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
            $table->text('objectives')->nullable(false)->change();
            $table->string('duration')->nullable(false)->change();
            $table->foreignId('status_id')->nullable(false)->change();
            $table->decimal('total_cost', 10, 2)->nullable(false)->change();
            $table->decimal('total_discount', 10, 2)->nullable(false)->change();
            $table->boolean('is_vat')->nullable(false)->change();
            $table->boolean('approved_by_admin')->nullable(false)->change();
        });

        Schema::table('contract_items', function (Blueprint $table) {
            $table->foreignId('contract_id')->nullable(false)->change();
            $table->foreignId('item_id')->nullable(false)->change();
            $table->decimal('cost', 10, 2)->nullable(false)->change();
            $table->integer('qty')->nullable(false)->change();
            $table->decimal('discount', 10, 2)->nullable(false)->change();
            $table->decimal('total_cost', 10, 2)->nullable(false)->change();
            $table->text('notes')->nullable(false)->change();
        });
    }
};
