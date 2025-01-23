<?php

namespace App\Http\Controllers\CP\Programs;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\Lead\LeadRequest;
use App\Http\Requests\CP\Program\ProgramRequest;
use App\Models\Apartment;
use App\Models\Attachment;
use App\Models\Constant;
use App\Models\Lead;
use App\Models\Program;
use App\Services\CP\Apartment\CheckApartmentStatusReadyToSale;
use App\Services\CP\Filters\ProgramFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class ProgramController extends Controller
{
    use HasCommonData;

    protected $filterService;
    protected $checkApartmentStatusReadyToSale;
    private $_model;

    public function __construct(Program $_model, ProgramFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }
    /**
     * Override getRequiredDropdowns instead of defining $requiredDropdowns property
     */
    protected function getRequiredDropdowns(): array
    {
        return [
            'index' => [],
            'create' => [],
            'edit' => [],
            'store' => [],
            'update' => [],
        ];
    }
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data = $this->getCommonData('index');
            return view($data['_view_path'] . 'index', $data);
        }
        if ($request->isMethod('POST')) {
            $items = $this->_model->query()->latest($this->_model::ui['table'] . '.updated_at');

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
                    // dd($item->name);
                    return '<a href="' . route($this->_model::ui['route'] . '.edit', ['_model' => $item->id]) . '"  class="">
                         ' . $item->name . '
                    </a>';
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
        $data = $this->getCommonData('create');
        $createView = view(
            $data['_view_path'] . '.addedit',
            $data
        )->render();
        return $createView;
    }
    public function edit(Request $request, Program $_model)
    {
        $data = $this->getCommonData('edit');

        $data['audits'] = $this->_model->audits()->with('user')->orderByDesc('created_at')->get();
        $data['attachmentAudits'] = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($_model) {
            $query->where('attachable_type', get_class($this->_model))
                ->where('attachable_id', $_model->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $data['_model'] = $_model;
        // dd($data);
        $createView = view(
            $data['_view_path'] . '.addedit',
            $data
        )->render();
        return $createView;
    }
    public function addedit(ProgramRequest $request)
    {
        Log::info('=== Starting ' . $this->_model::ui['s_ucf'] . ' Add/Edit Process ===', [
            'request_data' => $request->except(['password', 'token']),
            'user_id' => auth()->id()
        ]);

        try {
            DB::beginTransaction();

            // Get validated data
            $data = $request->all();

            // Extract ID
            $id = $request->get($this->_model::ui['_id']);
            // dd($id, $data);
            // If this is a new lead (no ID) and status or source is missing
            // if (!isset($id)) {
            //     // // Get pending status if not set
            //     // if (!isset($data['status_id'])) {
            //     //     Log::info('Status not provided, fetching pending status');

            //     //     $statusQuery = Constant::where([
            //     //         'module' => Modules::lead_module,
            //     //         'field' => DropDownFields::lead_status,
            //     //         'constant_name' => DropDownFields::lead_status_list['pending'],
            //     //     ]);

            //     //     logQuery($statusQuery, 'Fetching pending status for new lead');

            //     //     $pendingStatus = $statusQuery->first();

            //     //     if (!$pendingStatus) {
            //     //         throw new \Exception('System configuration error: Pending status not found');
            //     //     }

            //     //     $data['status_id'] = $pendingStatus->id;
            //     //     Log::info('Set default pending status', ['status_id' => $pendingStatus->id]);
            //     // }

            //     // Get dashboard source if not set
            //     if (!isset($data['source_id'])) {
            //         Log::info('Source not provided, fetching dashboard source');

            //         $sourceQuery = Constant::where([
            //             'module' => Modules::lead_module,
            //             'field' => DropDownFields::lead_source,
            //             'constant_name' => 'dashboard',  // Ensure this matches your constants
            //         ]);

            //         logQuery($sourceQuery, 'Fetching dashboard source for new lead');

            //         $dashboardSource = $sourceQuery->first();

            //         if (!$dashboardSource) {
            //             throw new \Exception('System configuration error: Dashboard source not found');
            //         }

            //         $data['source_id'] = $dashboardSource->id;
            //         Log::info('Set default dashboard source', ['source_id' => $dashboardSource->id]);
            //     }
            // }

            // Create or update logic
            if (isset($id)) {
                $item = $this->_model->findOrFail($id);
                // Update the lead
                $item->update($data);
            } else {
                // Create new lead
                $item = $this->_model->create($data);
            }

            DB::commit();

            $message = isset($id)
                ? t($this->_model::ui['s_ucf'] . ' has been updated successfully!')
                : t($this->_model::ui['s_ucf'] . ' has been added successfully!');

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'id' => $item->id,
                    'data' => $item->load(['apartment', 'leadFormType', 'status', 'source'])
                ]);
            }

            return redirect()
                ->route($this->_model::ui['route'] . '.edit', ['_model' => $item->id])
                ->with('status', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error in lead add/edit process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'token'])
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => []
                ], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([])
                ->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request, Program $_model)
    {
        try {
            DB::beginTransaction();
            $_model->delete();
            DB::commit();
            Log::info($_model::ui['s_ucf'] . ' deleted successfully', [$_model::ui['_id']  => $_model->id]);

            return jsonCRMResponse(true, t($_model::ui['s_ucf'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting ' . $_model::ui['s_ucf'], [
                $_model::ui['_id']  => $_model->id,
                'error' => $e->getMessage()
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $_model::ui['s_ucf'] . '. Please try again.', 500);
        }
    }




    public function export(Request $request)
    {
        $params = $request->all();
        $filterService = $this->filterService;

        return Excel::download(new LeadsExport($params, $filterService), $this->_model::ui['p_lcf'] . '.xlsx');
    }

    /**
     * Generate a price offer for a lead
     */
    public function request_price_offer(Request $request, Program $_model)
    {
        Log::info('Starting price offer request process', [
            'lead_id' => $_model->id,
            'lead_name' => $_model->name
        ]);

        try {
            DB::beginTransaction();
            // Check if lead has an apartment
            if (!$_model->apartment_id) {
                Log::warning('No apartment assigned to lead', ['lead_id' => $_model->id]);
                return $this->jsonResponse(false, t('Please choose an apartment first'), [], 400);
            }

            // Check if apartment is ready for sale
            $result = $this->checkApartmentStatusReadyToSale->checkReadyForSale($_model->apartment);

            if (!$result['status']) {
                return jsonCRMResponse(false, $result['message'], $result['code']);
            }

            // Check existing price offer
            if ($this->hasExistingPriceOffer($_model)) {
                return $this->jsonResponse(false, 'A price offer already exists for this lead', [], 400);
            }

            // Get required statuses
            $priceOfferStatus = $this->getPendingStatus();
            $leadStatus = $this->getLeadPriceOfferStatus();

            // Create price offer and update lead
            $priceOffer = $this->createPriceOffer($_model, $priceOfferStatus);
            $this->updateLeadStatus($_model, $leadStatus);

            DB::commit();

            return $this->jsonResponse(true, 'Price offer generated successfully', $priceOffer);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error generating price offer', [
                'lead_id' => $_model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->jsonResponse(false, 'An error occurred while generating the price offer', [], 500);
        }
    }

    /**
     * Check if lead already has a price offer
     */
    private function hasExistingPriceOffer(Lead $lead): bool
    {
        Log::info('Checking for existing price offer');

        if ($lead->price_offer()->exists()) {
            Log::warning('Price offer already exists', ['lead_id' => $lead->id]);
            return true;
        }

        return false;
    }

    /**
     * Get pending status for price offer
     */
    private function getPendingStatus(): Constant
    {
        $constantQuery = Constant::query()
            ->where('module', Modules::price_offer_module)
            ->where('field', DropDownFields::price_offer_status)
            ->where('constant_name', DropDownFields::price_offer_status_list['pending']);

        logQuery($constantQuery, 'Search for pending status constant');

        $pendingStatus = $constantQuery->first();

        if (!$pendingStatus) {
            Log::error('Pending status not found in constants', [
                'module' => Modules::price_offer_module,
                'field' => DropDownFields::price_offer_status,
                'searched_value' => DropDownFields::price_offer_status_list['pending']
            ]);

            throw new \Exception('System configuration error: Status ' .
                DropDownFields::price_offer_status_list['pending'] . ' not found');
        }

        Log::info('Found pending status', [
            'status_id' => $pendingStatus->id,
            'status_name' => $pendingStatus->name
        ]);

        return $pendingStatus;
    }

    /**
     * Get price offer request status for lead
     */
    private function getLeadPriceOfferStatus(): Constant
    {
        $constantQuery = Constant::query()
            ->where('module', Modules::lead_module)
            ->where('field', DropDownFields::lead_status)
            ->where('constant_name', DropDownFields::lead_status_list['request_for_price_offer']);

        logQuery($constantQuery, 'Search for lead price offer status constant');

        $status = $constantQuery->first();

        if (!$status) {
            throw new \Exception('System configuration error: Lead status request_for_price_offer not found');
        }

        return $status;
    }

    /**
     * Create new price offer
     */
    private function createPriceOffer(Lead $lead, Constant $status)
    {
        Log::info('Creating price offer');

        $priceOffer = $lead->price_offer()->create([
            'price' => $lead->apartment->price ?? 0,
            'down_payment' => 0,
            'status_id' => $status->id,
            'apartment_id' => $lead->apartment_id,
        ]);

        Log::info('Price offer created successfully', [
            'price_offer_id' => $priceOffer->id
        ]);

        return $priceOffer;
    }

    /**
     * Update lead status
     */
    private function updateLeadStatus(Lead $lead, Constant $status): void
    {
        Log::info('Updating lead status', [
            'lead_id' => $lead->id,
            'old_status' => $lead->status_id,
            'new_status' => $status->id
        ]);

        $lead->update(['status_id' => $status->id]);
    }

    /**
     * Generate JSON response
     */
    private function jsonResponse(bool $success, string $message, $data = [], int $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => t($message),
            'data' => $data,
            'errors' => $success ? [] : ['general' => [t($message)]]
        ], $status);
    }


    public function get_status_form(Request $request, Program $_model)
    {
        try {
            $data = $this->getCommonData('get_status_form');
            $data['title'] = t('Change Status');
            $data['_model'] = $_model;

            $createView = view($data['_view_path'] . '.status_form', $data)->render();
            return response()->json(['createView' => $createView]);
        } catch (\Exception $e) {
            Log::error('Error rendering change status view for insurance policy.', [
                'error' => $e->getMessage(),
                'policyOffer_id' => $_model->id,
            ]);

            return response()->json(['error' => t('An error occurred while rendering the change status view.')], 500);
        }
    }

    public function update_status(Request $request, Program $_model)
    {
        try {
            // Start logging - Initial request
            Log::info('Starting price offer status update', [
                'price_offer_id' => $_model->id,
                'requested_status_id' => $request->status_id,
                'current_datetime' => now()->toDateTimeString(),
            ]);

            // Get and log old status
            $oldStatus = $_model->status;
            Log::info('Current status details', [
                'price_offer_id' => $_model->id,
                'old_status_id' => $oldStatus->id,
                'old_status_name' => $oldStatus->name,
                'old_status_updated_at' => $_model->updated_at,
            ]);

            // Get and log new status
            $newStatus = Constant::findOrFail($request->status_id);
            Log::info('New status details', [
                'price_offer_id' => $_model->id,
                'new_status_id' => $newStatus->id,
                'new_status_name' => $newStatus->name,
                'requested_by' => auth()->id(),
            ]);
            if ($newStatus->constant_name == DropDownFields::price_offer_status_list['approved']) {
                $lead = $_model->lead;
                if (isset($lead)) {
                    $client = Client::updateOrCreate([
                        'lead_id' => $lead->id,
                        // 'price_offer_id' => $_model->id,
                    ], [
                        'name' => $lead->name,
                        'email' => $lead->email,
                        'phone' => $lead->phone,
                        'number_family_members' => $lead->number_family_members,
                        'active' => true,
                    ]);
                    $_model->update(['client_id' => $client->id]);
                }
            }

            // Perform update
            $_model->update([
                'status_id' => $newStatus->id,
                'status_updated_at' => now(),
            ]);

            // Log successful update
            Log::info('Price offer status updated successfully', [
                'price_offer_id' => $_model->id,
                'old_status' => [
                    'id' => $oldStatus->id,
                    'name' => $oldStatus->name,
                ],
                'new_status' => [
                    'id' => $newStatus->id,
                    'name' => $newStatus->name,
                ],
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'status' => true,
                'message' => t('Status has been updated successfully!'),
            ]);
        } catch (\Exception $e) {
            // Log error with comprehensive details
            Log::error('Failed to update price offer status', [
                'price_offer_id' => $_model->id,
                'requested_status_id' => $request->status_id,
                'current_status_id' => $_model->status_id,
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ],
                'user_id' => auth()->id(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => t('An error occurred while updating the status.'),
            ], 500);
        }
    }
}
