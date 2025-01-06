<?php

namespace App\Http\Controllers\Contracts;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\DepartmentsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Captin;
use App\Models\City;
use App\Models\ClientTrillion;
use App\Models\Constant;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Objective;
use App\Services\Dashboard\Filters\DepartmentFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Contract $_model, DepartmentFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }



    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view($this->_model::ui['p_lcf'] . '.index',);
        }
        if ($request->isMethod('POST')) {
            $items = $this->_model->query()->with(['client_trillion', 'contract_type', 'account_manager', 'status'])->withCount('items')->latest($this->_model::ui['table'] . '.updated_at');

            if ($request->input('params')) {
                $this->filterService->applyFilters($items, $request->input('params'));
            }

            //return $items->get();
            return DataTables::eloquent($items)
                ->editColumn('created_at', function ($item) {
                    if ($item->created_at)
                        return [
                            'display' => e(
                                $item->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $item->created_at->timestamp
                        ];
                })
                ->editColumn('name', function ($item) {
                    return '<a href="' . route($this->_model::ui['route'] . '.edit', [$this->_model::ui['s_lcf'] => $item->id]) . '" targer="_blank" class="">
                         ' . $item->name . '
                    </a>';
                })

                ->editColumn('active', function ($item) {
                    return $item->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })

                ->addColumn('action', function ($item) {
                    return $item->action_buttons;
                })
                //->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'mobile1', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $data = $this->getCommonData();
        $data['item_model'] = new $this->_model(); // Create a fresh instance
        $createView = view($this->_model::ui['p_lcf'] . '.addedit', $data)->render();
        return $createView;
    }
    public function edit(Request $request, Contract $contract)
    {
        $data = $this->getCommonData();

        $data['audits'] = $this->_model->audits()->with('user')->orderByDesc('created_at')->get();
        $data['attachmentAudits'] = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($contract) {
            $query->where('attachable_type', get_class($this->_model))
                ->where('attachable_id', $contract->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $data['item_model'] = $contract;
        // dd($data);
        $createView = view(
            $this->_model::ui['p_lcf'] . '.addedit',
            $data
        )->render();
        return $createView;
    }
    private function getCommonData()
    {
        $data['types'] = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)->get();
        $data['status_list'] = Constant::where('module', Modules::contract_module)->where('field', DropDownFields::status)->get();
        $data['countries'] = Country::all();
        $data['cities'] = City::all();
        $employees = Employee::all();
        $data['account_managers'] = $employees;
        $data['art_managers'] = $employees;
        $data['company_types'] = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
        $data['objective_types'] = Constant::where('module', Modules::main_module)->where('field', DropDownFields::objective_type)->get();
        // $data['contract_status'] = Constant::where('module', Modules::contract_module)->where('field', DropDownFields::status)->get();

        return $data;
    }


    public function updateTotalDiscount(Request $request, Contract $contract)
    {
        Log::info('Starting updateTotalDiscount', ['contract_id' => $contract->id]);

        try {
            $newDiscount = $request->total_discount;
            $oldTotalCost = $contract->getTotalCost();

            // Check if the discount is negative
            if ($newDiscount < 0) {
                Log::warning('Negative discount value', ['discount' => $newDiscount]);
                return response()->json([
                    'status' => false,
                    'color' => 'warning',
                    'message' => t('Discount cannot be negative. Please enter a positive value.'),
                    'total_cost' => $oldTotalCost

                ]);
            }

            $newTotalCost = $oldTotalCost - $newDiscount;

            Log::info('Calculation details', [
                'old_total_cost' => $oldTotalCost,
                'new_discount' => $newDiscount,
                'new_total_cost' => $newTotalCost
            ]);

            if ($newTotalCost < 0) {
                Log::warning('New total cost is negative', ['new_total_cost' => $newTotalCost]);
                return response()->json([
                    'status' => false,
                    'color' => 'error',
                    'message' => t('Total cost cannot be negative. Please enter a smaller discount.'),
                    'total_cost' => $oldTotalCost
                ]);
            }

            if ($oldTotalCost == $newTotalCost) {
                Log::info('Total cost unchanged');
                return response()->json([
                    'status' => true,
                    'color' => 'info',
                    'message' => t('Total cost unchanged, no update needed.'),
                    'total_cost' => $oldTotalCost
                ]);
            }

            DB::beginTransaction();
            $contract->total_cost = $newTotalCost;
            $contract->total_discount = $newDiscount;
            $contract->save();
            DB::commit();

            Log::info('Contract total cost updated', ['new_total_cost' => $newTotalCost]);

            return response()->json([
                'status' => true,
                'color' => 'success',
                'message' => t("Total cost has been updated successfully. New total cost is", ['newTotalCost' => $newTotalCost]),
                'total_cost' => $newTotalCost,
                'old_total_cost' => $oldTotalCost
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateTotalDiscount', [
                'contract_id' => $contract->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'color' => 'error',
                'message' => t('An error occurred while updating the total cost. Please try again.')
            ], 500);
        }
    }
    public function addeditOld(Request $request, $Id = null)
    {
        Log::info('addedit method called', ['Id' => $Id, 'Request Data' => $request->all()]);

        // Collect request data
        $data = $request->all();
        Log::info('Request data collected', ['Data' => $data]);

        // Handle the is_vat checkbox
        $data['is_vat'] = $request->has('is_vat');
        Log::info('is_vat processed', ['is_vat' => $data['is_vat']]);

        // Process date fields
        $data['start_date'] = $request->contract_start_date;
        $data['end_date'] = $request->contract_end_date;
        Log::info('Date fields processed', ['start_date' => $data['start_date'], 'end_date' => $data['end_date']]);

        Log::info('Request data fully processed', ['Processed Data' => $data]);

        // Validation (commented out in your code)
        // If you want to include validation, uncomment and add logging
        // try {
        //     $request->validate([
        //         'name' => 'required',
        //     ]);
        //     Log::info('Validation passed');
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     Log::error('Validation failed', ['errors' => $e->errors()]);
        //     throw $e;
        // }

        if (isset($Id)) {
            Log::info('Attempting to update ' . $this->_model::ui['s_lcf'], [$this->_model::ui['_id'] => $Id]);
            $item = $this->_model->find($Id);

            if ($item) {
                Log::info('Existing ' . $this->_model::ui['s_lcf'] . ' found', ['id' => $Id]);
                $item->update($data);
                Log::info($this->_model::ui['s_lcf'] . ' updated', [$this->_model::ui['_id'] => $item->id, 'Updated Data' => $data]);
            } else {
                Log::error($this->_model::ui['s_lcf'] . ' not found', [$this->_model::ui['_id'] => $Id]);
                return response()->json(['status' => false, 'message' => t($this->_model::ui['s_ucf'] . ' not found')], 404);
            }
        } else {
            Log::info('Creating a new ' . $this->_model::ui['s_lcf']);
            $item = $this->_model->create($data);
            Log::info($this->_model::ui['s_lcf'] . ' created', [$this->_model::ui['_id'] => $item->id, 'Created Data' => $data]);
        }

        // Prepare success message
        $message = isset($Id)
            ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
            : t($this->_model::ui['s_ucf'] . ' has been added successfully!');
        Log::info('Success message prepared', ['Message' => $message]);

        // Check if request is via AJAX
        if ($request->ajax()) {
            Log::info('Returning JSON response for AJAX request', ['status' => true, 'message' => $message]);
            return response()->json(['status' => true, 'message' => $message]);
        } else {
            $redirectRoute = route($this->_model::ui['route'] . '.edit', [$this->_model::ui['s_lcf'] => $item->id]);
            Log::info('Redirecting to ' . $this->_model::ui['s_lcf'] . ' edit page', ['redirect_route' => $redirectRoute]);
            return redirect($redirectRoute)->with('status', $message);
        }
    }



    private function handleClientInfo(&$data, $request)
    {
        Log::info('Handling client info', ['request' => $request->all()]);
        $data['active'] = $request->active_c == 'on' ? 1 : 0;


        if ($request->filled(ClientTrillion::ui['_id'])) {
            $client = ClientTrillion::findOrFail($request->input(ClientTrillion::ui['_id']));
            $client->update($data);
            Log::info('Updated existing client.', ['client_id' => $client->id]);
        } else {
            $client = ClientTrillion::create($data);
            $data['client_id'] = $client->id;
            Log::info('Created new client.', ['client_id' => $client->id]);
        }

        // Update the $data array with the client information
        $data[ClientTrillion::ui['_id']] = $client->id;
        return $client;
    }
    public function addedit(Request $request)
    {
        try {
            Log::info('=== Contract Add/Edit Process Started ===');
            Log::info('Raw request data:', ['request' => $request->all()]);

            // Collect request data
            $data = $request->all();
            $id = $request->get($this->_model::ui['_id'], null);
            Log::info('Extracted contract ID:', ['id' => $id]);

            // Log objectives data before processing
            Log::info('Raw objectives data:', [
                'objectives_input' => $request->objectives,
                'is_array' => is_array($request->objectives)
            ]);


            // Handle the is_vat checkbox
            $data['is_vat'] = $request->has('is_vat');
            Log::info('VAT status processed:', ['is_vat' => $data['is_vat']]);

            // Process date fields
            $data['start_date'] = $request->contract_start_date;
            Log::info('Contract start date:', ['start_date' => $data['start_date']]);

            // Calculate end date based on start date and duration
            if ($data['start_date'] && isset($data['duration'])) {
                $startDate = new \DateTime($data['start_date']);
                $duration = intval($data['duration']);
                $endDate = $startDate->modify("+{$duration} days");
                $data['end_date'] = $endDate->format('Y-m-d');
                Log::info('End date calculation:', [
                    'start_date' => $data['start_date'],
                    'duration' => $duration,
                    'calculated_end_date' => $data['end_date']
                ]);
            } else {
                Log::warning('End date calculation skipped:', [
                    'start_date_exists' => isset($data['start_date']),
                    'duration_exists' => isset($data['duration']),
                    'start_date' => $data['start_date'] ?? null,
                    'duration' => $data['duration'] ?? null
                ]);
            }

            // Handle client information
            Log::info('Processing client information...');
            $client = $this->handleClientInfo($data, $request);
            Log::info('Client information processed:', ['client_id' => $client->id ?? null]);

            // Create or update contract
            if (isset($id)) {
                Log::info('Updating existing contract:', ['contract_id' => $id]);
                $item = $this->_model->findOrFail($id);
                $item->update($data);
                Log::info('Contract updated successfully');
            } else {
                Log::info('Creating new contract');
                $item = $this->_model->create($data);
                Log::info('New contract created:', ['new_contract_id' => $item->id]);
            }
            $objectiveIds = handleObjectives($request);

            $item->objectives()->sync($objectiveIds);
            Log::info('Objectives synchronized successfully');

            // Prepare response
            $message = isset($id)
                ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
                : t($this->_model::ui['s_ucf'] . ' has been added successfully!');
            Log::info('Response message prepared:', ['message' => $message]);

            // Return response
            if ($request->ajax()) {
                Log::info('Sending AJAX response');
                return response()->json(['status' => true, 'message' => $message]);
            } else {
                Log::info('Preparing redirect response');
                $redirectRoute = route($this->_model::ui['route'] . '.edit', [
                    $this->_model::ui['s_lcf'] => $item->id
                ]);
                Log::info('Redirecting to:', ['route' => $redirectRoute]);
                return redirect($redirectRoute)->with('status', $message);
            }
        } catch (\Exception $e) {
            Log::error('=== Error in Contract Add/Edit Process ===');
            Log::error('Exception details:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'An error occurred: ' . $e->getMessage();

            if ($request->ajax()) {
                Log::info('Sending error response via AJAX');
                return response()->json([
                    'status' => false,
                    'message' => $errorMessage
                ], 422);
            } else {
                Log::info('Redirecting back with error');
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage)
                    ->with($this->_model::ui['_id'], $id);
            }
        } finally {
            Log::info('=== Contract Add/Edit Process Completed ===');
        }
    }





    public function delete(Request $request, Contract $contract)
    {
        try {
            DB::beginTransaction();

            // Check for related records
            if ($this->hasRelatedRecords($contract)) {
                DB::rollBack();
                return jsonCRMResponse(false, 'Cannot delete ' . $this->_model::ui['s_ucf'] . ' due to existing related records.', 422);
            }

            $contract->delete();

            DB::commit();

            Log::info($this->_model::ui['s_ucf'] . ' deleted successfully', [$this->_model::ui['_id']  => $contract->id]);

            return jsonCRMResponse(true, t($this->_model::ui['s_ucf'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting contract', [
                $this->_model::ui['_id']  => $contract->id,
                'error' => $e->getMessage()
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $this->_model::ui['s_ucf'] . '. Please try again.', 500);
        }
    }

    private function hasRelatedRecords(Contract $contract): bool
    {
        return $contract->projects()->exists() ||
            $contract->contract_items()->exists() ||
            $contract->items()->exists();
    }



    public function export(Request $request)
    {
        $params = $request->all();
        $filterService = $this->filterService;

        return Excel::download(new DepartmentsExport($params, $filterService), $this->_model::ui['p_lcf'] . '.xlsx');
    }



    public function viewAttachments(Request $request, Captin $captin)
    {

        $callsView = view(
            'captins.viewAttachments',
            [
                'captin' => $captin,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
