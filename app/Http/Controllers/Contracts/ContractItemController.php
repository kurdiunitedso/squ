<?php

namespace App\Http\Controllers\Contracts;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Project;
use App\Services\Dashboard\Filters\ContractItemFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ContractItemController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(ContractItem $_model, ContractItemFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }

    public function index(Request $request, Contract $contract)
    {
        if ($request->isMethod('GET')) {
            return view(Contract::ui['p_lcf'] . '.' . $this->_model::ui['p_lcf'] . '.index', compact('contract'));
        }
        if ($request->isMethod('POST')) {
            // Query for items with their individual total costs
            $items = $this->_model->query()
                ->with(['contract', 'item']) // Eager load contract
                ->where($this->_model::ui['table'] . '.contract_id', $contract->id)
                // ->select([
                //     $this->_model::ui['table'] . '.*',
                //     DB::raw('(cost * qty - discount) as total_cost')
                // ])
                ->latest($this->_model::ui['table'] . '.updated_at');
            // ->get();

            // Separate query for the contract total cost
            $contract_total_cost = $this->_model->query()
                ->where($this->_model::ui['table'] . '.contract_id', $contract->id)
                ->sum(DB::raw('cost * qty - discount'));

            // dd($contract_total_cost, $items);
            if ($request->input('params')) {
                $this->filterService->applyFilters($items, $request->input('params'));
            }
            return DataTables::eloquent($items)
                ->filterColumn('description', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('description', 'like', "%" . $value . "%");
                    });
                })
                ->addColumn('action', function ($item) {
                    return $item->action_buttons;
                })
                ->with('contract_total_cost', $contract_total_cost)
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function edit(Request $request, Contract $contract, ContractItem $contract_item)
    {
        $data['items'] = Item::all();
        $data['contract'] = $contract;
        $data['item_model'] = $contract_item;
        $createView = view(Contract::ui['p_lcf'] . '.' . $this->_model::ui['p_lcf'] . '.addedit', $data)->render();
        return response()->json(['createView' => $createView]);
    }

    public function addEditProject(Request $request, Contract $contract, ContractItem $contract_item)
    {
        // dd($contract_item);
        $data['types'] = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)->get();
        $data['status_list'] = Constant::where('module', Modules::project_module)->where('field', DropDownFields::status)->get();
        $data['account_managers'] = Employee::all();
        $data['art_managers'] = Employee::all();
        $data['company_types'] = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();

        $data['contract'] = $contract;
        $data['item_model'] = $contract_item;
        $createView = view(Contract::ui['p_lcf'] . '.' . $this->_model::ui['p_lcf'] . '.addEditProject', $data)->render();
        return response()->json(['createView' => $createView]);
    }
    public function storeProject(Request $request, Contract $contract, ContractItem $contract_item)
    {
        Log::info('=== Starting Project Store Process ===', [
            'contract_id' => $contract->id,
            'contract_item_id' => $contract_item->id,
            'item_id' => $contract_item->item_id,
            'request_data' => $request->all()
        ]);

        try {
            // Step 1: Log incoming request data
            Log::info('Validating request data', [
                'has_objectives' => $request->has('objectives'),
                'objectives_type' => gettype($request->objectives),
                'objectives_data' => $request->objectives
            ]);

            // Step 2: Prepare project data
            $data = $request->all();
            $data[ContractItem::ui['_id']] = $contract_item->id;
            Log::info('Project data prepared', [
                'contract_item_id_added' => $contract_item->id,
                'final_data' => $data
            ]);

            // Step 3: Create or update project with logging
            Log::info('Attempting to create/update project', [
                'search_criteria' => [
                    Contract::ui['_id'] => $contract->id,
                    Item::ui['_id'] => $contract_item->item_id,
                ]
            ]);

            $item = Project::updateOrCreate(
                [
                    Contract::ui['_id'] => $contract->id,
                    Item::ui['_id'] => $contract_item->item_id,
                ],
                $data
            );

            Log::info('Project created/updated successfully', [
                'project_id' => $item->id,
                'was_created' => $item->wasRecentlyCreated,
                'updated_fields' => $item->getDirty()
            ]);

            // Step 4: Handle objectives
            Log::info('Starting objectives processing');
            $objectiveIds = handleObjectives($request);
            Log::info('Objectives processed', [
                'objective_ids' => $objectiveIds,
                'count' => count($objectiveIds)
            ]);

            // Step 5: Sync objectives
            Log::info('Syncing objectives with project', [
                'project_id' => $item->id,
                'objective_ids' => $objectiveIds
            ]);

            // $previousObjectives = $item->objectives()->pluck('id')->toArray();
            $item->objectives()->sync($objectiveIds);

            // Log::info('Objectives synced successfully', [
            //     'previous_objectives' => $previousObjectives,
            //     'new_objectives' => $objectiveIds,
            //     'added' => array_diff($objectiveIds, $previousObjectives),
            //     'removed' => array_diff($previousObjectives, $objectiveIds)
            // ]);

            // Step 6: Prepare response
            $message = t(Project::ui['s_ucf'] . ' has been added successfully!');
            Log::info('Preparing response', [
                'message' => $message,
                'is_ajax' => $request->ajax()
            ]);

            // Step 7: Send response
            if ($request->ajax()) {
                Log::info('Sending AJAX response', [
                    'status' => true,
                    'message' => $message
                ]);
                return response()->json(['status' => true, 'message' => $message]);
            } else {
                $redirectRoute = route($this->_model::ui['route'] . '.edit', [
                    $this->_model::ui['s_lcf'] => $item->id
                ]);
                Log::info('Redirecting to edit page', [
                    'route' => $redirectRoute
                ]);
                return redirect($redirectRoute)->with('status', $message);
            }
        } catch (\Exception $e) {
            Log::error('=== Error in Project Store Process ===', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            $errorMessage = 'An error occurred while processing your request.';

            if ($request->ajax()) {
                Log::info('Sending error response via AJAX', [
                    'message' => $errorMessage
                ]);
                return response()->json([
                    'status' => false,
                    'message' => $errorMessage
                ], 500);
            } else {
                Log::info('Redirecting back with error', [
                    'message' => $errorMessage
                ]);
                return back()->withInput()->with('error', $errorMessage);
            }
        } finally {
            Log::info('=== Project Store Process Completed ===');
        }
    }


    public function create(Request $request, Contract $contract)
    {
        $items = Item::all();
        $createView = view(Contract::ui['p_lcf'] . '.' . $this->_model::ui['p_lcf'] . '.addedit', compact('contract', 'items'))->render();
        return response()->json(['createView' => $createView]);
    }



    public function store(Request $request, Contract $contract)
    {
        Log::info('Starting storeItem method', ['contract_id' => $contract->id]);

        try {
            DB::beginTransaction();
            Log::info('Database transaction started');

            // Step 1: Prepare data
            $id = $request->get(ContractItem::ui['_id'], null);
            $data = $request->all();
            $data['contract_id'] = $contract->id;
            $data['cost'] = $data[ContractItem::ui['s_lcf'] . '_cost'];
            $data['qty'] = $data[ContractItem::ui['s_lcf'] . '_qty'];
            $data['discount'] = $data[ContractItem::ui['s_lcf'] . '_discount'];
            $data['total_cost'] = $data['cost'] * $data['qty'] - $data['discount'];
            Log::info('Item data prepared', ['data' => $data]);
            // Step 2: Check for existing item or update
            if (isset($id)) {
                Log::info('Updating existing item', ['item_id' => $id]);
                $item = $this->_model->findOrFail($id);
                $item->update($data);
                Log::info('Item updated', ['item_id' => $item->id]);
            } else {
                Log::info('Checking for existing item in contract');
                $existingItem = $this->_model->where([
                    'item_id' => $data['item_id'],
                    'contract_id' => $contract->id
                ])->first();

                if ($existingItem) {
                    Log::warning('Attempt to add duplicate item', [
                        'item_id' => $data['item_id'],
                        'contract_id' => $contract->id
                    ]);
                    throw new \Exception(t("The item already exists in this contract. Please update the existing item instead."));
                }

                Log::info('Creating new item');
                $item = $this->_model->create($data);
                Log::info('New item created', ['item_id' => $item->id]);
            }


            // Step 3: Calculate new total cost
            // $data['total_discount'] = $data['contract_total_discount'];
            $newItemsTotal = $contract->getTotalCost();
            $newTotalCost = $newItemsTotal -  $contract->total_discount; //$data['total_discount'];
            Log::info('Total cost calculated', [
                'new_items_total' => $newItemsTotal,
                'contract_discount' => $contract->total_discount,
                'new_total_cost' => $newTotalCost
            ]);

            // Step 4: Check if total cost is valid
            if ($newTotalCost < 0) {
                Log::warning('Invalid total cost', ['new_total_cost' => $newTotalCost]);
                throw new \Exception('Total cost cannot be negative. Please review the item details and contract discount.');
            }

            // Step 5: Update contract total cost
            $contract->update([
                'total_cost' => $newTotalCost,
                // 'total_discount' => $data['contract_total_discount']
            ]);
            Log::info('Contract total cost updated', ['new_total_cost' => $newTotalCost]);

            DB::commit();
            Log::info('Database transaction committed');

            // Step 6: Prepare success message
            $action = isset($id) ? 'updated' : 'added';
            $message = t(ContractItem::ui['s_ucf'] . " has been {$action} successfully. Total Cost Now is {$newTotalCost}");
            Log::info('Success message prepared', ['message' => $message]);

            return $this->prepareResponse(true, 'success', $message, $newTotalCost);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in storeItem', [
                'contract_id' => $contract->id,
                'error' => $e->getMessage()
            ]);
            return $this->prepareResponse(false, 'error', $e->getMessage(), null);
        }
    }
    public function delete(Request $request, Contract $contract, ContractItem $contract_item)
    {
        DB::beginTransaction();
        try {
            // Delete the contract item
            $contract->contract_items()->findOrFail($contract_item->id)->delete();

            // Recalculate the total cost
            $newItemsTotal = $contract->getTotalCost();
            $newTotalCost = $newItemsTotal - $contract->total_discount;

            // Check if the new total cost is zero or negative
            if ($newTotalCost <= 0) {
                $contract->update([
                    'total_cost' => 0,
                    'total_discount' => 0
                ]);
                $newTotalCost = 0;
                Log::info('Contract total cost and discount reset to zero', [
                    'contract_id' => $contract->id
                ]);
            } else {
                // Update the contract with the new total cost
                $contract->update([
                    'total_cost' => $newTotalCost
                ]);
            }

            DB::commit();

            Log::info('Contract item deleted and total cost updated', [
                'contract_id' => $contract->id,
                'item_id' => $contract_item->id,
                'new_total_cost' => $newTotalCost,
                'new_total_discount' => $contract->total_discount
            ]);

            return response()->json([
                'status' => true,
                'message' => ContractItem::ui['s_ucf'] . ' Deleted Successfully!',
                'new_total_cost' => $newTotalCost,
                'new_total_discount' => $contract->total_discount
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Error deleting contract item', [
                'contract_id' => $contract->id,
                'item_id' => $contract_item->id,
                'error' => $ex->getMessage()
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete ' . ContractItem::ui['s_ucf'] . '. ' . $ex->getMessage()
            ], 500);
        }
    }

    private function prepareResponse($status, $color, $message, $totalCost)
    {
        return response()->json([
            'status' => $status,
            'color' => $color,
            'message' => $message,
            'total_cost' => $totalCost
        ]);
    }
}
