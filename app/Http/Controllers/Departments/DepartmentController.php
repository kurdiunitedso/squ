<?php

namespace App\Http\Controllers\Departments;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\CaptinsExport;
use App\Exports\DepartmentsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Captin;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;
use App\Models\Department;
use App\Models\Restaurant;
use App\Models\SystemSmsNotification;
use App\Models\Vehicle;
use App\Models\WhatsappHistory;
use App\Services\Dashboard\Filters\DepartmentFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Department $department, DepartmentFilterService $filterService)
    {
        Log::info('............... DepartmentController initialized with Department model ...........');
        $this->_model = $department;
        $this->filterService = $filterService;
    }



    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view('departments.index',);
        }
        if ($request->isMethod('POST')) {
            $items = $this->_model->query()->latest('updated_at');

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
                    return '<a href="' . route('departments.edit', ['department' => $item->id]) . '" targer="_blank" class="">
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
        $createView = view('departments.addedit')->render();
        return $createView;
    }



    public function addedit(Request $request, $Id = null)
    {
        Log::info('addedit method called', ['Id' => $Id, 'Request Data' => $request->all()]);

        // Collect request data and handle the active checkbox value
        $data = $request->all();
        $data['active'] = $request->active_c == 'on' ? 1 : 0;
        Log::info('Request data processed', ['Processed Data' => $data]);
        // Validate required fields
        $request->validate([
            'name' => 'required',
        ]);
        Log::info('Validation passed');

        if (isset($Id)) {
            Log::info('Attempting to update department', ['Department ID' => $Id]);
            // Update existing department
            $item = $this->_model->find($Id);

            if ($item) {
                $item->update($data);
                Log::info('Department updated', ['Department ID' => $item->id]);
            } else {
                Log::error('Department not found', ['Department ID' => $Id]);
                return response()->json(['status' => false, 'message' => t('Department not found')], 404);
            }
        } else {
            Log::info('Creating a new department');
            // Create new department
            $item = $this->_model->create($data);
            Log::info('Department created', ['Department ID' => $item->id]);
        }
        // Prepare success message
        $message = isset($Id)
            ? t('Department has been updated successfully!')
            : t('Department has been added successfully!');
        Log::info('Success message prepared', ['Message' => $message]);
        // Check if request is via AJAX
        if ($request->ajax()) {
            Log::info('Returning JSON response for AJAX request');
            return response()->json(['status' => true, 'message' => $message]);
        } else {
            Log::info('Redirecting to departments edit', ['Department ID' => $item->id]);
            return redirect()->route('departments.edit', [
                'department' => $item->id,
            ])->with('status', $message);
        }
    }


    public function edit(Request $request, Department $department)
    {
        $data['audits'] = $this->_model->audits()->with('user')->orderByDesc('created_at')->get();
        $data['attachmentAudits'] = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($department) {
            $query->where('attachable_type', get_class($this->_model))
                ->where('attachable_id', $department->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $data['item_model'] = $department;
        // dd($data);
        $createView = view(
            'departments.addedit',
            $data
        )->render();
        return $createView;
    }


    public function delete(Request $request, Department $department)
    {
        $department->delete();
        return response()->json(['status' => true, 'message' => t('Item Deleted Successfully!')]);
    }


    public function export(Request $request)
    {
        $params = $request->all();
        $filterService = $this->filterService;

        return Excel::download(new DepartmentsExport($params, $filterService), 'Departments.xlsx');
    }

    public function getByTelephone(Request $request, $telephone)
    {

        $items = Captin::with('city')->orwhere(DB::raw('RIGHT(mobile2,9)'), 'like', '%' . substr($telephone, -9) . '%')->where(DB::raw('RIGHT(mobile1,9)'), 'like', '%' . substr($telephone, -9) . '%')->get();
        $createView = view('captins.getByTelephone', [
            'captins' => $items,
        ])->render();
        return response()->json(['createView' => $createView]);
    }

    public function viewCalls(Request $request, Captin $captin)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($captin->mobile1, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($captin->mobile1, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($captin->mobile1, -9) . '%')->get();
        $callsView = view(
            'captins.viewCalls',
            [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'captin' => $captin,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
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

    public function viewTickets(Request $request, Captin $captin)
    {

        $callsView = view(
            'captins.viewTickets',
            [
                'captin' => $captin,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewVisits(Request $request, Captin $captin)
    {

        $callsView = view(
            'captins.viewVisits',
            [
                'captin' => $captin,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
