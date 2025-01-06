<?php

namespace App\Http\Controllers\CDR;


use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\CallTasksExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\ClientController;
use App\Models\CallTask;
use App\Models\CdrLog;
use App\Models\Constant;
use App\Models\Client;
use App\Models\User;
use App\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CallTaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            $EMPLOYEES = User::active()->get();
            $task_statuss = Constant::where('module', Modules::CALL)->where('field', DropDownFields::task_statuss)->get();
            $task_urgencys = Constant::where('module', Modules::CALL)->where('field', DropDownFields::task_urgencys)->get();


            return view('callTasks.index', compact(
                'EMPLOYEES', 'task_statuss'

            ));
        }
        if ($request->isMethod('POST')) {
            $callTasks = CallTask::with(
                'call',
                'task_statuss',
                'task_urgencys',
                'task_employees',

            )->withCount('calls', 'smss');
            if (!Auth::user()->hasRole('super-admin')) {
                $callTasks->where('task_employee', Auth::user()->id);
            }
//return $callTasks->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                /*   if ($search_params['employee_id'] != null) {
                       $callTasks->where('task_employee', $search_params['employee_id']);
                   }*/
                if ($search_params['task_status'] != null) {
                    $callTasks->where('task_status', $search_params['task_status']);
                }

                if ($search_params['call_date'] != null) {
                    $date = explode('to', $search_params['call_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $callTasks->whereBetween('created_at', [$date[0], $date[1]]);
                }


            }

            // return $callTasks->get();
            return DataTables::eloquent($callTasks)
                ->filterColumn('client.name_locale', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->whereHas('client', function ($subQuery) use ($value) {
                        $subQuery->where('client_name', 'like', "%" . $value . "%");

                    });
                })
                ->addColumn('call_caller_name', function ($callTask) {
                    return $callTask->call->caller->name;

                })
                ->addColumn('call_city_name', function ($callTask) {
                    return $callTask->call->city->name;

                })
                ->addColumn('call_employee_name', function ($callTask) {
                    return $callTask->call->employee->name;

                })
                ->addColumn('call_callOption_name', function ($callTask) {
                    return $callTask->call->callOption->name;

                })
                ->setRowClass(function ($data) {

                    return $data->task_status ? 'table-success' : 'table-default';
                })
                ->editColumn('listen', function ($callTask) {
                    //return strtok($callTask->call_id, '.');
                    $cllcdr = CdrLog::where('uniqueid', strtok($callTask->call_id, '.'))->get()->first();
                    if (isset($callcdr))
                        return '<a href="https://wheels.developon.co/records/' . $cllcdr->record_file_name . '" target="_blank">Listen</a>';
                    else
                        return '';
                })
                ->editColumn('created_at', function ($callTask) {
                    return [
                        'display' => e(
                            $callTask->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $callTask->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($callTask) {
                    $menu = '';
                    $smsAction = '';
                    $callAction = '';
                    $actionBtn = '<a href="' . route('call_tasks.action', ['call' => $callTask->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnAction">

<span class="svg-icon svg-icon-3"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Electric/Outlet.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M15,4 C15.5522847,4 16,4.44771525 16,5 L16,9 L14,9 L14,5 C14,4.44771525 14.4477153,4 15,4 Z M9,4 C9.55228475,4 10,4.44771525 10,5 L10,9 L8,9 L8,5 C8,4.44771525 8.44771525,4 9,4 Z" fill="#000000" opacity="0.3"/>
        <path d="M13,16.9291111 L13,22 L11,22 L11,16.9291111 C7.60770586,16.4438815 5,13.5264719 5,10 L5,9 L19,9 L19,10 C19,13.5264719 16.3922941,16.4438815 13,16.9291111 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>

                    </a>';


                    $removeBtn = $this->deleteButton(
                        route('call_tasks.delete', ['call' => $callTask->id]),
                        'btnDeleteCallTask',
                        'data-callTask-name="' . $callTask->name_en . '"'
                    );

                    $smsAction = '<a class="btn btn-icon btn-active-light-primary w-30px h-30px btnAddCallTaskSms" href="' . route('sms.callTask.create', ['callTask' => $callTask->id]) . '">
                                <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                    <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                    </svg>
                                </span>
                            </a>
                            ';


                    $callAction = '<a class="btn btn-icon btn-active-light-primary w-30px h-30px btnAddCallTaskCall" href="' . route('calls.callTask.create', ['callTask' => $callTask->id]) . '">
                                <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"
                                    />
                                </svg>
                                </span>
                            </a>
                            ';


                    $menu = '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                <span class="svg-icon svg-icon-3">
                                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="6" width="16" height="3" rx="1.5" fill="currentColor"/>
                                    <rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="currentColor"/>
                                    <rect opacity="0.3" width="12" height="3" rx="1.5" fill="currentColor"/>
                                    </svg>
                                </span>
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-175px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->';


                    $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('calls.callTask.view_calls', ['callTask' => $callTask->id]) . '" class="menu-link px-3 showCalls" data-kt-callTasks-table-actions="show_calls">
                                            Show Calls (' . $callTask->calls_count . ') & SMS (' . $callTask->smss_count . ')
                                        </a>
                                    </div>';


                    $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';


                    return $removeBtn . $actionBtn . $smsAction . $callAction . $menu;
                })
                ->rawColumns(['module', 'action', 'listen'])
                ->make();
        }
    }

    public function action(Request $request, CallTask $call)
    {

        $urgencys = Constant::where('module', Modules::CALL)->where('field', DropDownFields::urgency)->get();
        $task_statuss = Constant::where('module', Modules::CALL)->where('field', DropDownFields::task_statuss)->get();
        $employees = User::active()->get();
        $callsView = view('callTasks.actionView'
            , compact(
                'urgencys',
                'call',
                'call',
                'task_statuss',
                'employees',
            )
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function delete(Request $request, CallTask $call)
    {
        $call->delete();
        return response()->json(['status' => true, 'message' => 'Assign Deleted Successfully !']);
    }

    public function storeAction(Request $request, CallTask $call)
    {

        $call->update(
            $request->all()
        );


        return response()->json(['status' => true, 'message' => 'Assigned Successfully !']);
    }

    public function export(Request $request)
    {


        return Excel::download(new CallTasksExport(), 'CallsTask.xlsx');
    }

}
