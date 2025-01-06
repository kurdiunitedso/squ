<?php

namespace App\Http\Controllers\Orders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Captin;
use App\Models\Order;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;

use App\Models\Restaurant;
use App\Models\SystemSmsNotification;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $cities = City::all();
            $EMPLOYEES = User::all();

            $status = Constant::
            where('module', Modules::ORDER)->where('field', DropDownFields::status)->get();

            return view('orders.index', [
                'cities' => $cities
                , 'status' => $status
                , 'EMPLOYEES' => $EMPLOYEES
            ]);
        }
        if ($request->isMethod('POST')) {
            $orders = Order::with('city', 'employee');

            //return  $orders->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if ($search_params['delivery_status'] != null) {
                    $orders->where('delivery_status', 'like', "%" . $search_params['delivery_status'] . "%");
                }
                if ($search_params['captin_mobile'] != null) {
                    $orders->where('captin_mobile', 'like', "%" . $search_params['captin_mobile'] . "%");
                }
                if ($search_params['captin_name'] != null) {
                    $orders->where('captin_name', 'like', "%" . $search_params['captin_name'] . "%");
                }
                if ($search_params['expected_prep_time'] != null) {
                    $orders->where('expected_prep_time', $search_params['expected_prep_time']);
                }
                if ($search_params['pickup_time'] != null) {
                    $date = explode('to', $search_params['pickup_time']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $orders->whereBetween('pickup_time', [$date[0], $date[1]]);
                }
                if ($search_params['order_create_time'] != null) {
                    $orders->where('order_create_time', $search_params['order_create_time']);
                }
                if ($search_params['order_create_date'] != null) {
                    $date = explode('to', $search_params['order_create_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $orders->whereBetween('order_create_date', [$date[0], $date[1]]);

                }

                if ($search_params['payment_type'] != null) {
                    $orders->where('payment_type', 'like', "%" . $search_params['payment_type'] . "%");
                }
                if ($search_params['delivery_type'] != null) {
                    $orders->where('delivery_type', 'like', "%" . $search_params['delivery_type'] . "%");
                }
                if ($search_params['sub_destination'] != null) {
                    $orders->where('sub_destination', 'like', "%" . $search_params['sub_destination'] . "%");
                }
                if ($search_params['city'] != null) {
                    $orders->where('city', 'like', "%" . $search_params['city'] . "%");
                }
                if ($search_params['client_mobile'] != null) {
                    $orders->where('client_mobile', 'like', "%" . $search_params['client_mobile'] . "%");
                }
                if ($search_params['client_name'] != null) {
                    $orders->where('client_name', 'like', "%" . $search_params['client_name'] . "%");
                }
                if ($search_params['order_no'] != null) {
                    $orders->where('order_no', 'like', "%" . $search_params['order_no'] . "%");
                }
                if ($search_params['branch_name'] != null) {
                    $orders->where('branch_name', 'like', "%" . $search_params['branch_name'] . "%");
                }
                if ($search_params['restaurant_name'] != null) {
                    $orders->where('restaurant_name', 'like', "%" . $search_params['restaurant_name'] . "%");
                }
                if ($search_params['telephone'] != null) {
                    $orders->where('telephone', 'like', "%" . $search_params['telephone'] . "%");
                }


            }

            //return $orders->get();
            return DataTables::eloquent($orders)
                ->filterColumn('order_name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[5]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('visit_name', 'like', "%" . $value . "%");

                    });
                })
                ->editColumn('employee.name', function ($order) {
                    if ($order->employee) {
                        return '<a href="' . route('orders.edit', ['order' => $order->id]) . '" size="modal-xl" class=" btnUpdateorder">' . $order->employee->name . '</a>';
                    }
                    return $order->name;
                })
                ->editColumn('since', function ($order) {
                    if ($order->order_date) {
                        $date = Carbon::parse($order->order_date);
                        return $date->diffForHumans();
                    }
                })
                ->editColumn('telephone', function ($order) {
                    /* return '<a href="' . route('orders.view_calls', ['order' => $order->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                         . $order->telephone .
                         '</a>';*/
                    return $order->telephone;
                })
                ->addColumn('action', function ($order) {
                    $editBtn = $smsAction = $callAction = $menu = '';
                    if (Auth::user()->canAny(['order_edit'])) {
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

                    $editBtn = '<a href="' . route('orders.edit', ['order' => $order->id]) . '" size="modal-xl" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateorder">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-order-name="' . $order->name . '" href=' . route('orders.delete', ['order' => $order->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteorder"
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
                    $link = '    <a href="https://wheels.delivery/Login" target="_blank" class="btn font-weight-bold btn btn-icon btn-active-light-primary w-30px h-30px">

                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Devices/LTE1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Devices / LTE1</title>
    <desc>Created with Sketch.</desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M15.4508979,17.4029496 L14.1784978,15.8599014 C15.324501,14.9149052 16,13.5137472 16,12 C16,10.4912085 15.3289582,9.09418404 14.1893841,8.14910121 L15.466112,6.60963188 C17.0590936,7.93073905 18,9.88958759 18,12 C18,14.1173586 17.0528606,16.0819686 15.4508979,17.4029496 Z M18.0211112,20.4681628 L16.7438102,18.929169 C18.7927036,17.2286725 20,14.7140097 20,12 C20,9.28974232 18.7960666,6.77820732 16.7520315,5.07766256 L18.031149,3.54017812 C20.5271817,5.61676443 22,8.68922234 22,12 C22,15.3153667 20.523074,18.3916375 18.0211112,20.4681628 Z M8.54910207,17.4029496 C6.94713944,16.0819686 6,14.1173586 6,12 C6,9.88958759 6.94090645,7.93073905 8.53388797,6.60963188 L9.81061588,8.14910121 C8.67104182,9.09418404 8,10.4912085 8,12 C8,13.5137472 8.67549895,14.9149052 9.82150222,15.8599014 L8.54910207,17.4029496 Z M5.9788888,20.4681628 C3.47692603,18.3916375 2,15.3153667 2,12 C2,8.68922234 3.47281829,5.61676443 5.96885102,3.54017812 L7.24796852,5.07766256 C5.20393339,6.77820732 4,9.28974232 4,12 C4,14.7140097 5.20729644,17.2286725 7.25618985,18.929169 L5.9788888,20.4681628 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <circle fill="#000000" cx="12" cy="12" r="2"/>
    </g>
</svg><!--end::Svg Icon--></span>
            </a>';


                    return $editBtn . $removeBtn . $link;
                })
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

            $orders = Order::with('city', 'employee');

            $orders = $orders->where('client_mobile1','like', '%'.substr($telephone,-9).'%')
            ->orwhere('client_mobile2','like', '%'.substr($telephone,-9).'%');

            return DataTables::eloquent($orders)
                ->filterColumn('order_name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[5]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('visit_name', 'like', "%" . $value . "%");

                    });
                })
                ->editColumn('employee.name', function ($order) {

                    return $order->name;
                })
                ->editColumn('since', function ($order) {
                    if ($order->order_date) {
                        $date = Carbon::parse($order->order_date);
                        return $date->diffForHumans();
                    }
                })
                ->editColumn('telephone', function ($order) {
                    /* return '<a href="' . route('orders.view_calls', ['order' => $order->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                         . $order->telephone .
                         '</a>';*/
                    return $order->telephone;
                })

                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $cities = City::all();
        $EMPLOYEES = User::all();

        $order_type = Constant::where('module', Modules::ORDER)->where('field', DropDownFields::order_type)->get();
        $status = Constant::where('module', Modules::ORDER)->where('field', DropDownFields::status)->get();
        // $motor_cc=DropDownFields::MOTOR_CC;
        $createView = view('orders.addedit_modal', [

            'cities' => $cities
            , 'order_type' => $order_type
            , 'status' => $status
            , 'EMPLOYEES' => $EMPLOYEES

        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }

    public function createOrderCallCenter(Request $request)
    {
        $source_telephone = $request->source_telephone;
        $dest_telephon = $request->dest_telephone;
        $captin = Captin::where('mobile1', 'like', '%' . $source_telephone . '%')->orwhere('mobile2', 'like', '%' . $source_telephone . '%')->get()->first();
        $restaurant = Restaurant::where('wheels_id', 'like', '%' . $dest_telephon . '%')->get()->first();
        $client = \App\Models\Client::where('telephone', 'like', '%' . $source_telephone . '%')->get()->first();
        if (!isset($client)) {
            $client = new \App\Models\Client();
            $client->telephone = $source_telephone;
            $client->city_id = 2;
            $client->save();

        }
        if ($restaurant) {
            $order = new Order();
            $order->telephone = $source_telephone;
            $order->user_id = 1;
            $order->client_id = $client->id;
            $order->order_create_time = date('h:i:s');
            $order->order_create_date = date('Y-m-d');
            $order->client_name = $client->name;
            $order->restaurant_name = $restaurant->name;
            $order->restaurant_id = $restaurant->id;
            $order->save();
            $url = 'http://wheels.delivery/CallCenter/Order/'.$dest_telephon.'/'.$source_telephone.'?order_id='.$order->id;
            return redirect($url);
        }
        if ($captin || $dest_telephon=='wheels') {
            $ticket = new Ticket();
            $ticket->telephone = $source_telephone;
            $ticket->employee = 1;
            $ticket->category = 192;
            $ticket->city_id = 2;
            $ticket->save();
            $url = 'http://wheels.delivery/CRM/TicketsList/'.$source_telephone.'?ticket_id='.$ticket->id;
            return redirect($url);
        }

        $order = new Order();
        $order->telephone = $source_telephone;
        $order->user_id = 1;
        $order->client_id = $client->id;
        $order->order_create_time = date('h:i:s');
        $order->order_create_date = date('Y-m-d');
        $order->client_name = $client->name;
        $order->restaurant_name = '';
        $order->restaurant_id = null;
        $order->save();
        $url = 'http://wheels.delivery/CallCenter/Order/'.$dest_telephon.'/'.$source_telephone.'?order_id='.$order->id;
        return redirect($url);


    }


    public function Order(Request $request, $Id = null)
    {
        //return $request->all();
        if ($request->updateEmployee && isset($Id)) {
            $newOrder = Order::find($Id);
            $newOrder->update($request->all());
            if ($request->ajax())
                return response()->json(['status' => true, 'message' => 'Order has been added successfully!']);
        }

        /*  $request->validate([
              'visit_name' => 'required',

          ]);*/
        if (isset($Id)) {
            $newOrder = Order::find($Id);
            $newOrder->update($request->all());


        } else {
            $newOrder = Order::create($request->all());

        }

        $newOrder->save();

        $message = 'Order has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Order has been added successfully!']);
        else
            return redirect()->route('orders.index', [
                'Id' => $newOrder->id,
                //'order' => $newOrder->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Order $order)
    {
        $cities = City::all();
        $EMPLOYEES = User::all();

        $status = Constant::where('module', Modules::ORDER)->where('field', DropDownFields::status)->get();
        $order_type = Constant::where('module', Modules::ORDER)->where('field', DropDownFields::order_type)->get();


        $createView = view('orders.addedit_modal', [

                'cities' => $cities
                , 'order' => $order
                , 'order_type' => $order_type
                , 'status' => $status
                , 'EMPLOYEES' => $EMPLOYEES

            ]


        )->render();


        //return $createView;
        return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Order $Order)
    {
        $Order->delete();
        return response()->json(['status' => true, 'message' => 'Order Deleted Successfully !']);
    }

    public function export(Request $request)
    {

        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }

}




