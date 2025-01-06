<?php


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
        Schema::create(ContractItem::ui['table'], function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts');
            $table->foreignId('item_id')->constrained('items');
            $table->double('cost');
            $table->integer('qty');
            $table->double('discount')->default(0);
            $table->double('total_cost')->default(0);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->comment('item_id can represent either an item_id or a service_id');
        });
        if (DB::table(ContractItem::ui['table'])->where('id', 1)->doesntExist()) {
            $contract = Contract::first();
            $contractId = $contract->id ?? null;
            $contractId = Contract::first()->id ?? null;
            $itemId = Item::first()->id ?? null;
            if (isset($contractId) && isset($itemId)) {
                DB::beginTransaction();
                // Insert the provided data
                DB::table(ContractItem::ui['table'])->insert([
                    'id' => 1,
                    'contract_id' => $contractId,
                    'item_id' => $itemId,
                    'cost' => 30,
                    'qty' => 1,
                    'discount' => 0,
                    'total_cost' => 30,
                    'notes' => 'test notes',
                    'created_at' => '2024-10-23 10:14:49',
                    'updated_at' => '2024-10-31 10:14:49'
                ]);
                $contract->total_cost = $contract->getTotalCost();
                $contract->save();
                DB::commit();
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_items');
    }
};
