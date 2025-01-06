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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // $table->integer('visit_id')->nullable();
            //  $table->integer('type_id')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('lead_date')->nullable();
            // $table->integer('user_id')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_mobile')->nullable();
            $table->string('owner_email')->nullable();


            $table->string('manager_name')->nullable();
            $table->string('manager_social')->nullable();
            $table->string('manager_email')->nullable();
            $table->integer('wheels')->nullable();
            $table->integer('active')->nullable();
            //$table->integer('offer_id')->nullable();
            // $table->integer('offer_type')->nullable();
            // $table->integer('status')->nullable();

            $table->integer('marketing_type')->nullable();
            $table->string('marketing_name')->nullable();
            $table->float('marketing_cost')->nullable();

            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->softDeletes();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('type_id')->nullable()->constrained('constants');
            $table->foreignId('visit_id')->nullable()->constrained('visits');
            $table->foreignId('facility_id')->nullable()->constrained('facilities');
            $table->foreignId('status')->nullable()->constrained('constants');
            $table->foreignId('offer_type')->nullable()->constrained('constants');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
