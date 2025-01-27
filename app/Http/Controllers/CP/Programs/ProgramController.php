<?php

namespace App\Http\Controllers\CP\Programs;

use App\Exports\LeadsExport;
use App\Exports\ProgramExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\Program\ProgramRequest;
use App\Models\Attachment;
use App\Models\Program;
use App\Services\CP\Filters\ProgramFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'create' => [
                'program_target_applicants_list',
                'program_category_list',
                'program_eligibility_type_list',
                'program_facility_list'
            ],
            'edit' => [
                'program_target_applicants_list',
                'program_category_list',
                'program_eligibility_type_list',
                'program_facility_list'
            ]
        ];
    }
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data = $this->getCommonData('index');
            return view($data['_view_path'] . 'index', $data);
        }
        if ($request->isMethod('POST')) {
            $items = $this->_model->query()
                ->with([
                    'target_applicant',
                    'category',
                ])->latest($this->_model::ui['table'] . '.updated_at');

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
            // Sync eligibilities if provided
            if ($request->has('eligibility_ids')) {
                $item->syncEligibilities($request->input('eligibility_ids'));
            }
            if ($request->has('facility_ids')) {
                $item->syncFacilities($request->input('facility_ids'));
            }
            if ($request->has('important_dates')) {
                $item->important_dates()->delete();
                foreach ($request->input('important_dates') as $date) {
                    // dd($date);
                    $item->important_dates()->create([
                        'title' => [
                            'en' => $date['en'],
                            'ar' => $date['ar'],
                        ],
                        'date' => $date['date']
                    ]);
                }
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

        return Excel::download(new ProgramExport($params, $filterService), $this->_model::ui['p_lcf'] . '.xlsx');
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
}
