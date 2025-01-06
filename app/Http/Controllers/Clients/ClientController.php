<?php

namespace App\Http\Controllers\Clients;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\CaptinsExport;
use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\ClientCallAction;
use App\Models\Constant;

use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $cities = City::all();

            $category = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::category)->get();
            $status = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::status)->get();
            $client_types = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::client_type)->get();

            return view('clients.index', [
                'cities' => $cities,
                'category' => $category,
                'client_types' => $client_types,
                'status' => $status
            ]);
        }
        if ($request->isMethod('POST')) {
            $clients = Client::
            select('clients.*')
                ->with('city', 'categoryss', 'statuss')
                ->withCount('orders')
                ->withCount('attachments')
                ->withCount('callPhone')
                ->withCount('smsPhone');
            // return  $clients->get();
            if ($request->type_id != null) {
                $clients->where('type_id', $request->type_id);
            }
            if ($request->input('params')) {
                $search_params = $request->input('params');


                if (array_key_exists('city_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['city_id']);
                    if (count($results) > 0)
                        $clients->whereIn('city_id', $results);

                }

                if (array_key_exists('category', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['category']);
                    if (count($results) > 0)
                        $clients->whereIn('category', $results);
                    //$clients->where('category', $search_params['category']);
                }

                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $clients->whereIn('status', $results);

                }
                if (array_key_exists('type_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type_id']);
                    if (count($results) > 0)
                        $clients->whereIn('type_id', $results);
                    //$clients->where('type_id', $search_params['type_id']);
                }
                if ($search_params['orders_bot_min'] != null) {
                    $clients->where('orders_bot', '>=', $search_params['orders_bot_min']);
                }
                if ($search_params['orders_box_min'] != null) {
                    $clients->where('orders_bot', '>=', $search_params['orders_box_min']);
                }
                if ($search_params['orders_now_min'] != null) {
                    $clients->where('orders_bot', '>=', $search_params['orders_now_min']);
                }


                if ($search_params['orders_bot_max'] != null) {
                    $clients->where('orders_bot', '<=', $search_params['orders_bot_max']);
                }
                if ($search_params['orders_box_max'] != null) {
                    $clients->where('orders_bot', '<=', $search_params['orders_box_max']);
                }
                if ($search_params['orders_now_max'] != null) {
                    $clients->where('orders_bot', '<=', $search_params['orders_now_max']);
                }


                if (array_key_exists('attachment_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['attachment_id']);
                    if (count($results) > 0)
                        $clients->attachments->whereIn('attachment_type_id', $results);
                }

                if ($search_params['last_orders_box'] != null) {
                    $date = explode('to', $search_params['last_orders_box']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $clients->whereBetween('join_date', [$date[0], $date[1]]);
                }
                if ($search_params['last_orders_bot'] != null) {
                    $date = explode('to', $search_params['last_orders_bot']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $clients->whereBetween('last_orders_bot', [$date[0], $date[1]]);
                }
                if ($search_params['last_orders_now'] != null) {
                    $date = explode('to', $search_params['last_orders_now']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $clients->whereBetween('last_orders_now', [$date[0], $date[1]]);
                }


                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $clients->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                        $q->orwhere('client_id', 'like', "%" . $value . "%");
                    });
                }


            }

            //return $clients->get();
            return DataTables::eloquent($clients)
                ->editColumn('created_at', function ($client) {
                    if ($client->created_at)
                        return [
                            'display' => e(
                                $client->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $client->created_at->timestamp
                        ];
                })
                ->editColumn('name', function ($client) {
                    return '<a href="' . route('clients.edit', ['client' => $client->id]) . '" targer="_blank" class="">
                         ' . $client->name . '
                    </a>';
                })
                ->editColumn('client_id', function ($client) {
                    return '<a href="' . route('clients.edit', ['client' => $client->id]) . '" targer="_blank" class="">
                         ' . $client->client_id . '
                    </a>';
                })
                ->editColumn('telephone', function ($client) {
                    return '<a href="' . route('clients.view_calls', ['client' => $client->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $client->telephone .
                        '</a>';
                })
                ->editColumn('active', function ($client) {
                    return $client->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->addColumn('action', function ($client) {
                    $editBtn = $smsAction = $callAction = $menu = '';
                    if (Auth::user()->canAny(['client_register_history_access', 'client_sms_access', 'client_call_access', 'client_edit'])) {
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


                        if (Auth::user()->can('client_edit')) {

                            $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('clients.view_attachments', ['client' => $client->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                            Show Attachments (' . $client->attachments_count . ')
                                        </a>
                                    </div>';
                        }


                        $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                    }

                    $editBtn = '<a href="' . route('clients.edit', ['client' => $client->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateclient">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $creatVisit = '  <button type="button" url="' . route('visitRequests.create') . '?telephone=' . $client->telephone. '&selectedClients=' . $client->id . '&visit_name=' . $client->name . '&visit_category=250" class="btn btn-icon btn-active-light-primary w-30px h-30px" id="AddvisitsModal">
                                <span class="indicator-label">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <title>Stockholm-icons / Communication / Clipboard-check</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="currentColor"></path>
                                        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"></path>
                                        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                                    </span>
                                </span>

                            </button>';

                    $removeBtn = '<a data-client-name="' . $client->name . '" href=' . route('clients.delete', ['client' => $client->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteclient"
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

                   /* if (Auth::user()->can('client_sms_add')) {
                        $smsAction = '<a class="btn btn-icon btn-active-light-primary w-30px h-30px btnAddClientSms" href="' . route('sms.client.create', ['client' => $client->id]) . '">
                                <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                    <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                    </svg>
                                </span>
                            </a>
                            ';
                    }*/
                  /*  if (Auth::user()->can('client_call_add')) {
                        $callAction = '<a class="btn btn-icon btn-active-light-primary w-30px h-30px btnAddClientCall" href="' . route('calls.client.create', ['client' => $client->id]) . '">
                                <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"
                                    />
                                </svg>
                                </span>
                            </a>
                            ';
                    }*/
                    return $menu . $callAction . $smsAction . $editBtn . $removeBtn . $creatVisit;
                })
                ->escapeColumns([])
                // ->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'telephone', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $cities = City::all();
        $category = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::category)->get();
        $status = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::status)->get();
        $client_types = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::client_type)->get();
        $call = ClientCallAction::find($request->call_id);
        // $motor_cc=DropDownFields::MOTOR_CC;
        $createView = view('clients.addedit', [
            'cities' => $cities
            , 'category' => $category
            , 'status' => $status
            , 'client_types' => $client_types
            , 'call' => $call

        ])->render();
        return $createView;
    }


    public function Client(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',

        ]);
        if (isset($Id)) {
            $newClient = Client::find($Id);
            $newClient->update($request->all());

        } else
            $newClient = Client::create($request->all());
        $newClient->active = $request->active_c == 'on' ? 1 : 0;
        $newClient->save();


        $message = 'Client has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Client has been added successfully!']);
        else
            return redirect()->route('clients.index', [
                'Id' => $newClient->id,
                //'client' => $newClient->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Client $client)
    {

        $cities = City::all();
        $category = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::category)->get();
        $status = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::status)->get();
        $client_types = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::client_type)->get();
        $audits = $client->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($client) {
            $query->where('attachable_type', client::class)
                ->where('attachable_id', $client->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $createView = view('clients.addedit', [
                'cities' => $cities,
                'client' => $client,
                'category' => $category,
                'audits' => $audits,
                'attachmentAudits' => $attachmentAudits,
                'client_types' => $client_types,
                'status' => $status

            ]


        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Client $Client)
    {
        $Client->delete();
        return response()->json(['status' => true, 'message' => 'Client Deleted Successfully !']);
    }


    public function getByTelephone(Request $request, $telephone)
    {

        $clients = Client::with('city')->orwhere(DB::raw('RIGHT(telephone,9)'), 'like', '%' . substr($telephone, -9) . '%')->where(DB::raw('RIGHT(telephone,9)'), 'like', '%' . substr($telephone, -9) . '%')->get();
        $createView = view('clients.getByTelephone', [
            'clients' => $clients,
        ])->render();
        return response()->json(['createView' => $createView]);


    }

    public function viewCalls(Request $request, Client $client)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($client->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($client->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($client->telephone, -9) . '%')->get();
        $callsView = view('clients.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'client' => $client,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

    public function export(Request $request)
    {
        /*$c=new ClientsExport($request->all());
        return $c->view();*/
        return Excel::download(new ClientsExport($request->all()), 'Clients.xlsx');
    }

    public function viewAttachments(Request $request, Client $client)
    {

        $callsView = view('clients.viewAttachments'
            , [
                'client' => $client,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }
}
