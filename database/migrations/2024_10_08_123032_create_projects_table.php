<?php

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Constant;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(Project::ui['table'], function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts');
            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->foreignId(ContractItem::ui['_id'])->nullable()->constrained(ContractItem::ui['table']);

            $table->foreignId('project_type_id')->constrained('constants');
            $table->foreignId('status_id')->nullable()->constrained('constants');
            $table->text('objectives')->nullable();
            $table->foreignId('account_manager_id')->constrained('employees');
            $table->foreignId('art_manager_id')->constrained('employees');
            $table->integer('frequency')->default(0);
            $table->integer('duration')->default(0);
            $table->integer('qty')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Add a unique constraint on the combination of contract_id and item_id
            $table->unique(['contract_id', 'item_id']);
        });

        // Insert a sample project if it doesn't exist
        if (DB::table(Project::ui['table'])->where('id', 1)->doesntExist()) {
            $contract = Contract::first();
            $item = Item::first();
            if ($contract && $item) {
                DB::transaction(function () use ($contract, $item) {
                    DB::table(Project::ui['table'])->insert([
                        'id' => 1,
                        'contract_id' => $contract->id,
                        'item_id' => $item->id,
                        'project_type_id' => Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)->first()->id ?? null,
                        'status_id' => Constant::where('module', Modules::contract_module)->where('field', DropDownFields::status)->first()->id ?? null,
                        'objectives' => 'Sample project objectives',
                        'account_manager_id' => Employee::latest('updated_at')->first()->id ?? 1,
                        'art_manager_id' => Employee::latest('updated_at')->skip(1)->first()->id ?? 2,
                        'frequency' => 1,
                        'duration' => 30,
                        'qty' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                });
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(Project::ui['table']);
    }
};
