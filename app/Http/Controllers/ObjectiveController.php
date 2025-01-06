<?php

namespace App\Http\Controllers;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Constant;
use App\Models\Objective;
use App\Services\Dashboard\Filters\ObjectiveFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class ObjectiveController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Objective $_model, ObjectiveFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }



    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view('settings.' . $this->_model::ui['p_lcf'] . '.index',);
        }
        if ($request->isMethod('POST')) {
            $items = $this->_model->query()->with(['objective_type'])->latest($this->_model::ui['table'] . '.updated_at');

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
                    return '<a href="' . route('settings.' . $this->_model::ui['route'] . '.edit', [$this->_model::ui['s_lcf'] => $item->id]) . '" targer="_blank" class="">
                         ' . $item->name . '
                    </a>';
                })

                ->editColumn('active', function ($item) {
                    return $item->is_active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
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
        $createView = view('settings.' . $this->_model::ui['p_lcf'] . '.addedit', $data)->render();
        return $createView;
    }
    public function edit(Request $request, Objective $Objective)
    {
        $data = $this->getCommonData();

        $data['audits'] = $this->_model->audits()->with('user')->orderByDesc('created_at')->get();
        $data['attachmentAudits'] = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($Objective) {
            $query->where('attachable_type', get_class($this->_model))
                ->where('attachable_id', $Objective->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $data['item_model'] = $Objective;
        // dd($data);
        $createView = view(
            'settings.' . $this->_model::ui['p_lcf'] . '.addedit',
            $data
        )->render();
        return $createView;
    }
    private function getCommonData()
    {

        $data['objective_types'] = Constant::where('module', Modules::main_module)->where('field', DropDownFields::objective_type)->get();
        return $data;
    }



    public function store(Request $request)
    {
        try {

            // Collect request data
            $data = $request->all();
            $id = $request->get($this->_model::ui['_id'], null);
            $data['is_active'] = $request->has('is_active');
            if (isset($id)) {
                $item = $this->_model->findOrFail($id);
                $item->update($data);
            } else {
                $item = $this->_model->create($data);
            }

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





    public function delete(Request $request, Objective $objective)
    {
        try {
            DB::beginTransaction();



            $objective->delete();

            DB::commit();

            Log::info($this->_model::ui['s_ucf'] . ' deleted successfully', [$this->_model::ui['_id']  => $objective->id]);

            return jsonCRMResponse(true, t($this->_model::ui['s_ucf'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting$objective', [
                $this->_model::ui['_id']  => $objective->id,
                'error' => $e->getMessage()
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $this->_model::ui['s_ucf'] . '. Please try again.', 500);
        }
    }
}
