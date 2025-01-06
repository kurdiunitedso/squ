<?php

namespace App\Http\Controllers\Projects;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\ProjectsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Constant;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Project;
use App\Services\Dashboard\Filters\ProjectFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Project $_model, ProjectFilterService $filterService)
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
            $items = $this->_model->query()->with(['contract_item', 'project_type', 'account_manager', 'art_manager', 'contract.client_trillion', 'item', 'status'])->withCount(['projectEmployees'])->latest($this->_model::ui['table'] . '.updated_at');

            if ($request->input('params')) {
                $this->filterService->applyFilters($items, $request->input('params'));
            }
            // dd($items->get());

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
    public function edit(Request $request, Project $project)
    {
        $data = $this->getCommonData();

        $data['audits'] = $this->_model->audits()->with('user')->orderByDesc('created_at')->get();
        $data['attachmentAudits'] = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($project) {
            $query->where('attachable_type', get_class($this->_model))
                ->where('attachable_id', $project->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $data['item_model'] = $project->load('contract_item');
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
        $data['status_list'] = Constant::where('module', Modules::project_module)->where('field', DropDownFields::status)->get();
        $data['task_assignment_status_list'] = Constant::where('module', Modules::task_assignments_module)->where('field', DropDownFields::employee_task_assignment_status)->get();
        $data['contracts'] = Contract::all();
        $employees = Employee::where(['active' => true])->get();
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


    public function addedit(Request $request)
    {
        Log::info('addedit method started', ['request' => $request->all()]);

        DB::beginTransaction();
        try {
            // Collect request data
            $data = $request->all();
            Log::info('Request data collected', ['data' => $data]);

            $data['item_id'] = ContractItem::find($request->contract_item_id)->item_id ?? null;
            Log::info('item_id set', ['item_id' => $data['item_id']]);

            $id = $data[$this->_model::ui['_id']] ?? null;
            Log::info('ID extracted', ['id' => $id]);

            // Calculate end date based on start date and duration (in days)
            if ($data['start_date'] && isset($data['duration'])) {
                $startDate = new \DateTime($data['start_date']);
                $duration = intval($data['duration']);
                $endDate = $startDate->modify("+{$duration} days");
                $data['end_date'] = $endDate->format('Y-m-d');
                Log::info('End date calculated', ['end_date' => $data['end_date'], 'duration_days' => $duration]);
            } else {
                Log::warning('Unable to calculate end date', ['start_date' => $data['start_date'], 'duration' => $data['duration'] ?? 'not set']);
            }

            Log::info('Attempting to save/update record');
            if (isset($id)) {
                $item = $this->_model->findOrFail($id);
                Log::info('Existing record found', ['id' => $id]);
                $item->update($data);
                Log::info('Record updated', ['id' => $id]);
            } else {
                $item = $this->_model->create($data);
                Log::info('New record created', ['id' => $item->id]);
            }

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

            // Prepare success message
            $message = isset($id)
                ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
                : t($this->_model::ui['s_ucf'] . ' has been added successfully!');
            Log::info('Success message prepared', ['message' => $message]);

            DB::commit();
            Log::info('Database transaction committed');

            // Check if request is via AJAX
            if ($request->ajax()) {
                Log::info('Returning JSON response for AJAX request');
                return response()->json(['status' => true, 'message' => $message]);
            } else {
                $redirectRoute = route($this->_model::ui['route'] . '.edit', [$this->_model::ui['s_lcf'] => $item->id]);
                Log::info('Redirecting to edit page', ['route' => $redirectRoute]);
                return redirect($redirectRoute)->with('status', $message);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in addedit method. Transaction rolled back.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'An error occurred: ' . $e->getMessage();

            if ($request->ajax()) {
                Log::info('Returning JSON error response for AJAX request');
                return response()->json(['status' => false, 'message' => $errorMessage], 422);
            } else {
                Log::info('Redirecting back with error message');
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage)
                    ->with($this->_model::ui['_id'], $id);
            }
        }
    }





    public function delete(Request $request, Project $project)
    {
        try {
            DB::beginTransaction();

            // Check for related records
            if ($this->hasRelatedRecords($project)) {
                DB::rollBack();
                return jsonCRMResponse(false, 'Cannot delete ' . $this->_model::ui['s_ucf'] . ' due to existing related records.', 422);
            }

            $project->delete();

            DB::commit();

            Log::info($this->_model::ui['s_ucf'] . ' deleted successfully', [$this->_model::ui['_id']  => $project->id]);

            return jsonCRMResponse(true, t($this->_model::ui['s_ucf'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting ' . $this->_model::ui['s_ucf'], [
                $this->_model::ui['_id']  => $project->id,
                'error' => $e->getMessage()
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $this->_model::ui['s_ucf'] . '. Please try again.', 500);
        }
    }

    private function hasRelatedRecords(Project $project): bool
    {
        return $project->projectEmployees()->exists() ||
            $project->tasks()->exists();
    }


    public function export(Request $request)
    {
        $params = $request->all();
        $filterService = $this->filterService;

        return Excel::download(new ProjectsExport($this->_model, $filterService, $params), $this->_model::ui['p_lcf'] . '.xlsx');
    }
}
