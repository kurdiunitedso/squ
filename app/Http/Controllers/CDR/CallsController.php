<?php

namespace App\Http\Controllers\CDR;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\ClientCallActionsExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\ClientController;
use App\Models\Call;
use App\Models\CallTask;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Complain;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\Restaurant;
use App\Models\Captin;
use App\Models\Client;
use App\Models\ClientCallAction;
use App\Models\SystemSmsNotification;
use App\Models\User;
use App\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CallsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            $EMPLOYEES = User::active()->get();
            $CALLOPTIONS = Constant::where('module', Modules::CALL)->where('field', DropDownFields::CALL_OPTION_TYPE)->get();
            $caller_types = Constant::where('module', Modules::CALL)->where('field', DropDownFields::caller_type)->get();
            $call_statuss = Constant::where('module', Modules::CALL)->where('field', DropDownFields::call_status)->get();
            $cities = City::all();
            $urgencys = Constant::where('module', Modules::CALL)->where('field', DropDownFields::urgency)->get();

            return view('clientCallActions.index', compact(
                'EMPLOYEES',
                'CALLOPTIONS', 'caller_types', 'call_statuss',
                'cities', 'urgencys'

            ));
        }
        if ($request->isMethod('POST')) {
            $clientCallActions = ClientCallAction::with(
                'callcdr',
                'employee',
                'visit', 'ticket', 'client',
                'assign_statuss',
                'urgency',
                'assign',
                'city',
                'statuss',
                'callOption',
                'caller',
            )->withCount('callPhone2')->withCount('callPhone')->withCount('smsPhone');

//return $clientCallActions->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if (array_key_exists('call_option_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['call_option_id']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('call_option_id', $results);
                }

                if (array_key_exists('city_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['city_id']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('city_id', $results);
                }


                if (array_key_exists('assign_employee', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['assign_employee']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('assign_employee', $results);
                }
                if (array_key_exists('caller_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['caller_type']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('caller_type', $results);
                }
                if (array_key_exists('call_status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['call_status']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('call_status', $results);
                }


                if ($search_params['duration'] != null) {
                    $clientCallActions->where('duration', '>=', $search_params['duration']);
                }


                if (array_key_exists('urgency', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['urgency']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('urgency', $results);
                }


                if (array_key_exists('employee_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['employee_id']);
                    if (count($results) > 0)
                        $clientCallActions->whereIn('employee_id', $results);
                }


                if ($search_params['call_date'] != null) {
                    $date = explode('to', $search_params['call_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $clientCallActions->whereBetween('created_at', [$date[0], $date[1]]);
                }

                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? true : false;
                    $clientCallActions->where('status', $status);
                }
            }

            // return $clientCallActions->get();
            return DataTables::eloquent($clientCallActions)
                ->filterColumn('client_name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[4]['search']['value'];
                    $query->where(function ($subQuery) use ($value) {
                        $subQuery->where('client_name', 'like', "%" . $value . "%");
                        $subQuery->where('client_name_ar', 'like', "%" . $value . "%");
                        $subQuery->orwhere('telephone', 'like', "%" . $value . "%");

                    });
                })
                ->addColumn('client_name', function ($clientCallAction) {
                    $item = 0;
                    $item = Restaurant::where('telephone','like','%'. $clientCallAction->telephone.'%')->get()->first();
                    if (isset($item))
                        return '<a href="' . route('restaurants.edit', ['restaurant' => $item->id]) . '" target="_blank">' . $item->name . '</a>';
                    $item = Captin::where('mobile1','like','%'. $clientCallAction->telephone.'%')->orwhere('mobile2','like','%'. $clientCallAction->telephone.'%')->get()->first();
                    if (isset($item))
                        return '<a href="' . route('captins.edit', ['captin' => $item->id]) . '" target="_blank">' . $item->name . '</a>';
                    $item = Client::where('mobile','like','%'. $clientCallAction->telephone.'%')->get()->first();
                    if (isset($item))
                        return '<a href="' . route('clients.edit', ['client' => $item->id]) . '" target="_blank">' . $item->name . '</a>';
                    return $clientCallAction->client_name;

                })
                ->addColumn('module', function ($clientCallAction) {
                    return $clientCallAction->call_action;

                })
                ->setRowClass(function ($data) {

                    return $data->assign_status ? 'table-success' : 'table-default';
                })
                ->editColumn('listen', function ($clientCallAction) {
                    //return strtok($clientCallAction->call_id, '.');
                    $cllcdr = CdrLog::where('uniqueid', strtok($clientCallAction->call_id, '.'))->get()->first();
                    if (isset($callcdr))
                        return '<a href="https://wheels.developon.co/records/' . $cllcdr->record_file_name . '" target="_blank">Listen</a>';
                    else
                        return '';
                })
                ->editColumn('telephonee', function ($clientCallAction) {
                    return '<a href="' . route('client_calls_actions.view_calls', ['clientCallAction' => $clientCallAction->id]) . '"  class="viewCalls" size="lg" data-kt-calls-table-actions="show_calls">'
                        . $clientCallAction->telephone .
                        '</a>';
                    // return $ticket->telephone;
                })
                ->editColumn('created_at', function ($clientCallAction) {
                    return [
                        'display' => e(
                            $clientCallAction->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $clientCallAction->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($clientCallAction) {
                    $menue = '';
                    $assignBtn = '<a href="' . route('client_calls_actions.assign', ['call' => $clientCallAction->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnAssign">

<span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3" d="M5.78001 21.115L3.28001 21.949C3.10897 22.0059 2.92548 22.0141 2.75004 21.9727C2.57461 21.9312 2.41416 21.8418 2.28669 21.7144C2.15923 21.5869 2.06975 21.4264 2.0283 21.251C1.98685 21.0755 1.99507 20.892 2.05201 20.7209L2.886 18.2209L7.22801 13.879L10.128 16.774L5.78001 21.115Z" fill="currentColor"/>
<path d="M21.7 8.08899L15.911 2.30005C15.8161 2.2049 15.7033 2.12939 15.5792 2.07788C15.455 2.02637 15.3219 1.99988 15.1875 1.99988C15.0531 1.99988 14.92 2.02637 14.7958 2.07788C14.6717 2.12939 14.5589 2.2049 14.464 2.30005L13.74 3.02295C13.548 3.21498 13.4402 3.4754 13.4402 3.74695C13.4402 4.01849 13.548 4.27892 13.74 4.47095L14.464 5.19397L11.303 8.35498C10.1615 7.80702 8.87825 7.62639 7.62985 7.83789C6.38145 8.04939 5.2293 8.64265 4.332 9.53601C4.14026 9.72817 4.03256 9.98855 4.03256 10.26C4.03256 10.5315 4.14026 10.7918 4.332 10.984L13.016 19.667C13.208 19.859 13.4684 19.9668 13.74 19.9668C14.0115 19.9668 14.272 19.859 14.464 19.667C15.3575 18.77 15.9509 17.618 16.1624 16.3698C16.374 15.1215 16.1932 13.8383 15.645 12.697L18.806 9.53601L19.529 10.26C19.721 10.452 19.9814 10.5598 20.253 10.5598C20.5245 10.5598 20.785 10.452 20.977 10.26L21.7 9.53601C21.7952 9.44108 21.8706 9.32825 21.9221 9.2041C21.9737 9.07995 22.0002 8.94691 22.0002 8.8125C22.0002 8.67809 21.9737 8.54505 21.9221 8.4209C21.8706 8.29675 21.7952 8.18392 21.7 8.08899Z" fill="currentColor"/>
</svg>
</span>

                    </a>';

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

                    //   if (Auth::user()->can('captin_call_access')) {
                    if (isset($clientCallAction->visit->id))
                        $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('visits.edit', ['visit' => $clientCallAction->visit]) . '" class="btnUpdatevisit menu-link px-3" data-kt-captins-table-actions="showVisit">
                                            Show Visit
                                        </a>
                                    </div>';
                    //   }
                    //   if (Auth::user()->can('captin_edit')) {
                    if (isset($clientCallAction->ticket->id))
                        $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('tickets.edit', ['ticket' => $clientCallAction->ticket->id]) . '" class=" btnUpdateticket menu-link px-3" data-kt-captins-table-actions="showTicket">
                                            Show Ticket
                                        </a>
                                    </div>';

                    if (isset($clientCallAction->client->id))
                        $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('clients.edit', ['client' => $clientCallAction->client->id]) . '" class="menu-link px-3" target="_blank">
                                            Show Client
                                        </a>
                                    </div>';

                    $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('client_calls_actions.view_calls', ['clientCallAction' => $clientCallAction->id]) . '"  class="viewCalls menu-link px-3"" data-kt-captins-table-actions="show_calls">Show Calls & SMS
                                        </a>
                                    </div>';
                    $menu .= '   <div class="menu-item px-3"> <a href="javascript:;" type="button" url="' . route('visits.create') . '?telephone=' . $clientCallAction->telephone . '$visit=' . $clientCallAction->name . '&call_id=' . $clientCallAction->id . '" class="menu-link px-3" id="AddvisitsModal">
                               Create Visit</a></div>';
                       $menu .= ' <div class="menu-item px-3"> <a href="javascript:;" url="' . route('tickets.create') . '?telephone=' . $clientCallAction->telephone . '$visit=' . $clientCallAction->name . '&call_id=' . $clientCallAction->id . '" class="menu-link px-3" id="AddticketsModal">
                                Create Ticket
                            </a></div>';

                       $menu .= '<div class="menu-item px-3">   <a href="' . route('clients.create') . '?telephone=' . $clientCallAction->telephone . '$visit=' . $clientCallAction->name . '&call_id=' . $clientCallAction->id . '" class="menu-link px-3" target="_blank">

     Create Client
                            </a></div>';
                    //  }


                    $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';




                    $editBtn = $this->editButton(
                        route('client_calls_actions.create', [
                            'client_id' => $clientCallAction->client_id,
                            'clientCallAction' => $clientCallAction->id
                        ]),
                        'btnUpdateClientCallAction'
                    );
                    $removeBtn = $this->deleteButton(
                        route('client_calls_actions.delete', ['clientCallAction' => $clientCallAction->id]),
                        'btnDeleteClientCallAction',
                        'data-clientCallAction-name="' . $clientCallAction->name_en . '"'
                    );
                    return $editBtn . $removeBtn . $assignBtn  . $menu;
                })
                ->
                escapeColumns([])
                ->make();
        }
    }


    public
    function create(Request $request)
    {

        if ($request->has('clientCallAction')) {
            $clientCallAction = ClientCallAction::find($request->get('clientCallAction'));
        } else
            $clientCallAction = null;
        $CALL_OPTION_TYPES = Constant::where('module', Modules::CALL)->where('field', DropDownFields::CALL_OPTION_TYPE)->get();
        $urgencys = Constant::where('module', Modules::CALL)->where('field', DropDownFields::urgency)->get();
        $assign_statuss = Constant::where('module', Modules::CALL)->where('field', DropDownFields::assign_status)->get();
        $employees = User::active()->get();
        $cities = City::all();
        $caller_types = Constant::where('module', Modules::CALL)->where('field', DropDownFields::caller_type)->get();
        $call_statuss = Constant::where('module', Modules::CALL)->where('field', DropDownFields::call_status)->get();


        return view('clientCallActions.addedit', compact(
            'CALL_OPTION_TYPES',
            'clientCallAction',
            'urgencys',
            'assign_statuss',
            'employees',
            'cities',
            'caller_types',
            'call_statuss',

        ));
    }


    public
    function ClientCall(Request $request, $Id = null)
    {
        // dd($request->all());
        $client_id = null;
        $clientCallAction = null;

        $request->validate([


        ]);

        if ($request->has('client_id')) {


        } else {

        }

        //Create Internal Appointment
        $captin = null;

        $callAction = null;


        $clientCallAction = ClientCallAction::updateOrCreate(
            ['id' => $Id],
            [

                'telephone' => $request->call_telephone,
                'employee_id' => Auth::user()->id,
                'call_option_id' => $request->call_option_id,
                'client_name' => $request->client_name,

                'urgency' => $request->urgency,
                'assign_status' => $request->assign_status,
                'assign_employee' => $request->assign_employee,
                'city_id' => $request->city_id,
                'duration' => $request->duration,
                'caller_type' => $request->caller_type,
                'call_status' => $request->call_status,


                'notes' => $request->call_notes
            ]
        );


        $message = "";

        $clientCallAction != null ? $message = "Call was successfully Updated!" : $message = "Call was successfully added!";

        return redirect()->route('client_calls_actions.create', ['clientCallAction' => $clientCallAction->id])->with('status', $message);
    }

    public
    function storeAssign(Request $request, ClientCallAction $call)
    {

        $call->update(
            $request->all()
        );
        if ($call)
            CallTask::create(['call_id' => $call->id, 'task_employee' => $call->assign_employee,
                'call_urgency' => $call->urgency]);

        //if($callTask)


        return response()->json(['status' => true, 'message' => 'Assigned Successfully !']);
    }


    public
    function export(Request $request)
    {
        $name = $request->name;
        $call_option_id = $request->call_option_id;

        $employee_id = $request->employee_id;

        $call_date = $request->call_date;
        $is_active = $request->is_active;

        return Excel::download(new ClientCallActionsExport($name, $call_option_id, $employee_id, $call_date, $is_active), 'clientCallActions.xlsx');
    }

    public
    function assign(Request $request, ClientCallAction $call)
    {

        $urgencys = Constant::where('module', Modules::CALL)->where('field', DropDownFields::urgency)->get();
        $assign_statuss = Constant::where('module', Modules::CALL)->where('field', DropDownFields::assign_status)->get();
        $employees = User::active()->get();
        $callsView = view('clientCallActions.assignView'
            , compact(
                'urgencys',
                'call',
                'assign_statuss',
                'employees',
            )
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public
    function viewCalls(Request $request, $call)
    {
        $call = ClientCallAction::find($call);

        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($call->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($call->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($call->telephone, -9) . '%')->get();
        $callsView = view('clientCallActions.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'clientCallActions' => $call,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

}
