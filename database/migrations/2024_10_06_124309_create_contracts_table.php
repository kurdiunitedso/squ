<?php

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use App\Models\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('contracts');

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_trillion_id')->nullable()->constrained('client_trillions');
            $table->foreignId('account_manager_id')->nullable()->constrained('employees');
            $table->foreignId('offer_id')->nullable()->constrained('offers');
            $table->foreignId('type_id')->nullable()->constrained('constants');
            $table->foreignId('status_id')->nullable()->constrained('constants');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('duration')->nullable();
            $table->double('total_discount')->default(0);
            $table->double('total_cost')->default(0);
            $table->text('objectives')->nullable();
            $table->boolean('is_vat')->default(false);
            $table->boolean('approved_by_admin')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        /* if (DB::table(Contract::ui['table_name'])->where('id', 1)->doesntExist()) {
            // Insert the provided data
            DB::table(Contract::ui['table'])->insert([
                'id' => 1,
                'client_trillion_id' => 6,
                'account_manager_id' => 1,
                'offer_id' => 3,
                'type_id' => Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)->first()->id ?? null,
                'status_id' => Constant::where('module', Modules::contract_module)->where('field', DropDownFields::status)->first()->id ?? null,
                'start_date' => '2024-10-09 10:14:49',
                'end_date' => '2024-10-31 10:14:49',
                'objectives' => 'fsasdfasd fasd ',
                'is_vat' => 1,
                'duration' => 1,
                'approved_by_admin' => 1,
                'created_at' => '2024-10-23 10:14:49',
                'updated_at' => '2024-10-31 10:14:49'
            ]);
        }*/
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
