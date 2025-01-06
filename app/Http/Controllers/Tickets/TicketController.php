<?php

namespace App\Http\Controllers\Tickets;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\TicketsExport;
use App\Exports\VisitExport;
use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\Captin;
use App\Models\ClientCallAction;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;

use App\Models\SystemSmsNotification;
use App\Models\TicketAnswer;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $cities = City::all();
            $EMPLOYEES = User::all();
            $purpose = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::purpose)->get();
            $priority = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::priority)->get();
            $category = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::category)->get();
            $status = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::status)->get();

            return view('tickets.index', [
                'purpose' => $purpose,
                'priority' => $priority
                , 'category' => $category
                , 'cities' => $cities
                , 'status' => $status
                , 'EMPLOYEES' => $EMPLOYEES
            ]);
        }
        if ($request->isMethod('POST')) {
            $tickets = Ticket::with('cities', 'categories', 'priorities', 'ticket_types', 'purposes', 'statuses', 'employees');
            $tickets=$tickets->select('*',DB::raw('request_name as name'));
            //return  $tickets->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('city_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['city_id']);
                    if (count($results) > 0)
                        $tickets->whereIn('city_id', $results);

                }


                if (array_key_exists('source', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['source']);
                    if (count($results) > 0)
                        $tickets->whereIn('source', $results);

                }

                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $tickets->whereIn('status', $results);

                }


                if (array_key_exists('category', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['category']);
                    if (count($results) > 0)
                        $tickets->whereIn('category', $results);

                }

                if (array_key_exists('purpose', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['purpose']);
                    if (count($results) > 0)
                        $tickets->whereIn('purpose', $results);

                }


                if (array_key_exists('priority', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['priority']);
                    if (count($results) > 0)
                        $tickets->whereIn('priority', $results);

                }


                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $tickets->whereIn('status', $results);

                }


                if ($search_params['telephone'] != null) {
                    $tickets->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
                }

                if ($search_params['ticket_date'] != null) {
                    $date = explode('to', $search_params['ticket_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $tickets->whereBetween('ticket_date', [$date[0], $date[1]]);
                }

            }

            //return $tickets->get();
            return DataTables::eloquent($tickets)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[5]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('visit_name', 'like', "%" . $value . "%");

                    });
                })
                ->editColumn('created_at', function ($ticket) {
                    return [
                        'display' => e(
                            $ticket->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $ticket->created_at->timestamp
                    ];
                })
                ->editColumn('ticket_date', function ($ticket) {
                    if ($ticket->ticket_date) {
                        $date = Carbon::parse($ticket->ticket_date);
                        return $date->format('Y-m-d');
                    }

                })
                ->editColumn('ticket_time', function ($ticket) {

                    if ($ticket->ticket_date) {
                        $date = Carbon::parse($ticket->ticket_date);
                        return $date->format('H:i');
                    }


                })
                ->editColumn('since', function ($ticket) {
                    if ($ticket->ticket_date) {
                        $date = Carbon::parse($ticket->ticket_date);
                        return $date->diffForHumans();
                    }
                })
                ->editColumn('ticket_number', function ($ticket) {
                    if ($ticket->employees)
                        return '<a href="' . route('tickets.edit', ['ticket' => $ticket->id]) . '?updateAnswer=1" size="modal-xl" class="btnUpdateticket" >' . $ticket->ticket_number . ' </a>';
                    else
                        return 'NA';

                })
                ->editColumn('employee_name', function ($ticket) {
                    if ($ticket->employees)
                        return '<a href="' . route('tickets.edit', ['ticket' => $ticket->id]) . '?updateEmployee=1" size="modal-sm" class="btnUpdateticket" >' . $ticket->employees->name . ' </a>';
                    else
                        return 'NA';

                })
                ->editColumn('telephone', function ($ticket) {
                    return '<a href="' . route('tickets.view_calls', ['ticket' => $ticket->id]) . '"  class="viewCalls" size="lg" data-kt-calls-table-actions="show_calls">'
                        . $ticket->telephone .
                        '</a>';
                    // return $ticket->telephone;
                })
                ->addColumn('action', function ($ticket) {
                    $editBtn = $smsAction = $callAction = $menu = '';
                    if (Auth::user()->canAny(['ticket_edit'])) {
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
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                    }

                    $editBtn = '<a href="' . route('tickets.edit', ['ticket' => $ticket->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateticket" size="modal-xl">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-ticket-name="' . $ticket->name . '" href=' . route('tickets.delete', ['ticket' => $ticket->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteticket"
                                >
                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>';


                    return $editBtn . $removeBtn;
                })
                //->rawColumns(['action', 'active', 'ticket_number', 'employee_name', 'telephone'])
                ->escapeColumns([])
                ->make();
        }
    }

    public function indexByPhone(Request $request)
    {

        if ($request->isMethod('POST')) {
            $telephone = $request->telephone;
            if (!$telephone)
                return [];

            $tickets = Ticket::with('cities', 'categories', 'priorities', 'ticket_types', 'purposes', 'statuses', 'employees');

            $tickets = $tickets->where('telephone' ,'like', '%'.substr($telephone,-9).'%');

            return DataTables::eloquent($tickets)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[5]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('visit_name', 'like', "%" . $value . "%");

                    });
                })
                ->editColumn('created_at', function ($ticket) {
                    return [
                        'display' => e(
                            $ticket->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $ticket->created_at->timestamp
                    ];
                })
                ->editColumn('ticket_date', function ($ticket) {
                    if ($ticket->ticket_date) {
                        $date = Carbon::parse($ticket->ticket_date);
                        return $date->format('Y-m-d');
                    }

                })
                ->editColumn('ticket_time', function ($ticket) {

                    if ($ticket->ticket_date) {
                        $date = Carbon::parse($ticket->ticket_date);
                        return $date->format('H:i');
                    }


                })
                ->editColumn('since', function ($ticket) {
                    if ($ticket->ticket_date) {
                        $date = Carbon::parse($ticket->ticket_date);
                        return $date->diffForHumans();
                    }
                })
                ->editColumn('ticket_number', function ($ticket) {

                        return $ticket->ticket_number ;

                })
                ->editColumn('employee_name', function ($ticket) {

                        return  $ticket->employees->name ;

                })
                ->editColumn('telephone', function ($ticket) {

                    return  $ticket->employees->name ;
                    // return $ticket->telephone;
                })

                //->rawColumns(['action', 'active', 'ticket_number', 'employee_name', 'telephone'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $cities = City::all();
        $EMPLOYEES = User::all();
        $purpose = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::purpose)->get();
        $priority = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::priority)->get();
        $category = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::category)->get();
        $ticket_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::ticket_type)->get();
        $refund_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::refund_type)->get();
        $targets = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::targets)->get();
        $destinations = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::destinations)->get();
        $status = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::status)->get();
        // $motor_cc=DropDownFields::MOTOR_CC;
        $call=ClientCallAction::find($request->call_id);
        $createView = view('tickets.addedit_modal', [
            'purpose' => $purpose,
            'priority' => $priority
            , 'category' => $category
            , 'cities' => $cities
            , 'call' => $call
            , 'targets' => $targets
            , 'refund_type' => $refund_type
            , 'destinations' => $destinations
            , 'ticket_type' => $ticket_type
            , 'status' => $status
            , 'EMPLOYEES' => $EMPLOYEES

        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }


    public function Ticket(Request $request, $Id = null)
    {
        //return $request->all();
        if (($request->updateEmployee == 1 || $request->updateAnswer == 1) && isset($Id)) {
            $newTicket = Ticket::find($Id);
            $newTicket->update($request->all());
            if ($request->ajax())
                return response()->json(['status' => true, 'message' => 'Ticket has been added successfully!']);
        }

        /*  $request->validate([
              'visit_name' => 'required',

          ]);*/
        if (isset($Id)) {
            $newTicket = Ticket::find($Id);
            $newTicket->update($request->all());
            if ($request->is_refund) {
                $newTicket->refund = $request->is_refund == 'on' ? 1 : 0;
                $newTicket->save();
            }

            if ($request->ticket_date != null)
                $ticket_date = $request->ticket_date . ' ' . $request->ticket_time . ':00';
            else
                $ticket_date = null;
            $newTicket->ticket_date = $ticket_date;


        } else {
            $newTicket = Ticket::create($request->all());
            if ($request->ticket_date != null)
                $ticket_date = $request->ticket_date . ' ' . $request->ticket_time . ':00';
            else
                $ticket_date = null;
            $newTicket->ticket_date = $ticket_date;

        }

        $newTicket->save();

        $message = 'Ticket has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Ticket has been added successfully!']);
        else
            return redirect()->route('tickets.index', [
                'Id' => $newTicket->id,
                //'ticket' => $newTicket->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Ticket $ticket)
    {
        $cities = City::all();
        $EMPLOYEES = User::all();
        $purpose = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::purpose)->get();
        $priority = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::priority)->get();
        $category = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::category)->get();
        $status = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::status)->get();
        $ticket_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::ticket_type)->get();
        $targets = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::targets)->get();
        $destinations = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::destinations)->get();
        $refund_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::refund_type)->get();
        $tickerAnswers=TicketAnswer::where('ticket_id',$ticket->id)->with('user','ticket')->get();
        $visits = explode(',', $ticket->selectedVisit);

        $tickets = explode(',', $ticket->selectedTicket);
        $calls = explode(',', $ticket->selectedCalls);
        $orders = explode(',', $ticket->selectedOrder);

        if (count($visits) > 0)
            $visits = Visit::with('cities', 'categories', 'priorities', 'visit_types', 'periods', 'statuses', 'employees')->wherein('id', $visits);

        if (count($tickets) > 0)
            $tickets = Ticket::with('cities', 'categories', 'priorities', 'ticket_types', 'purposes', 'statuses', 'employees')->wherein('id', $tickets);
        if (count($calls) > 0)
            $calls = CdrLog::wherein('id', $calls);
        if (count($orders) > 0)
            $orders = Order::with('city', 'employee')->wherein('id', $orders);

        if ($request->typeGetData == 1 && $request->dataType == 'tickets')
            return DataTables::eloquent($tickets)->make();
        if ($request->typeGetData == 1 && $request->dataType == 'visits')
            return DataTables::eloquent($visits)->make();
        if ($request->typeGetData == 1 && $request->dataType == 'orders')
            return DataTables::eloquent($orders)->make();
        if ($request->typeGetData == 1 && $request->dataType == 'calls')
            return DataTables::eloquent($calls)->editColumn('date', function ($cdrLog) {
                return [
                    'display' => e(
                        $cdrLog->date->format('m/d/Y h:i A')
                    ),
                    'timestamp' => $cdrLog->date->timestamp
                ];
            })->make();


        if ($request->updateEmployee == 1)
            $createView = view('tickets.editEmployee_modal', [

                    'ticket' => $ticket

                    , 'EMPLOYEES' => $EMPLOYEES
                    , 'user' => Auth::user()
                ]


            )->render();
        else if ($request->updateAnswer == 1)
            $createView = view('tickets.answer_modal', [

                    'ticket' => $ticket
                    , 'destinations' => $destinations
                    , 'targets' => $targets
                    , 'refund_type' => $refund_type
                    , 'tickerAnswers' => $tickerAnswers
                    , 'status' => $status
                    , 'user' => Auth::user()

                ]


            )->render();
        else
            // return  DataTables::eloquent($tickets)->make();
            $createView = view('tickets.addedit_modal', [
                    'purpose' => $purpose,
                    'priority' => $priority
                    , 'category' => $category
                    , 'cities' => $cities
                    , 'ticket' => $ticket
                    , 'refund_type' => $refund_type
                    , 'ticket_type' => $ticket_type
                    , 'status' => $status
                    , 'EMPLOYEES' => $EMPLOYEES
                    , 'user' => Auth::user()
                    , 'targets' => $targets
                    , 'tickerAnswers' => $tickerAnswers
                    , 'destinations' => $destinations
                ]


            )->render();


        //return $createView;
        return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Ticket $Ticket)
    {
        $Ticket->delete();
        return response()->json(['status' => true, 'message' => 'Ticket Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*    $d= new VisitExport($request->all());
            return $d->view();*/
        return Excel::download(new TicketsExport($request->all()), 'tickets.xlsx');
    }

    public function viewCalls(Request $request, Ticket $ticket)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($ticket->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($ticket->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($ticket->telephone, -9) . '%')->get();
        $callsView = view('tickets.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'ticket' => $ticket,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

    public function createAnswer($ticket)
    {
        $callsView = view('tickets.ticket_answer'
            , [
                'ticket' => $ticket,

            ])->render();
        return $callsView;

    }

    public function storeAnswer(Ticket $ticket,Request $request)
    {
        $ticket_answer = TicketAnswer::create($request->all());
        $callsView = view('tickets.ticket_answer'
            , [
                'ticket_answer' => $ticket_answer,
                'ticket' => $ticket,
                'user' => Auth::user(),

            ])->render();
        return $callsView;
    }
}




