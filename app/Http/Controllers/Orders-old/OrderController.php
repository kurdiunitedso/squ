<?php

namespace App\Http\Controllers\Orders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;

use App\Models\SystemSmsNotification;
use App\Models\User;
use Carbon\Carbon;
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

            $status = Constant::where('module', Modules::ORDER)->where('field', DropDownFields::status)->get();

            return view('orders.index', [
                'cities' => $cities
                , 'status' => $status
                , 'EMPLOYEES' => $EMPLOYEES
            ]);
        }
        if ($request->isMethod('POST')) {
            $orders = Order::with('cities', 'order_types', 'statuses', 'employees');

            //return  $orders->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if ($search_params['city_id'] != null) {
                    $orders->where('city_id', $search_params['city_id']);
                }
                if ($search_params['status'] != null) {
                    $orders->where('status', $search_params['status']);
                }

                if ($search_params['status'] != null) {
                    $orders->where('status', $search_params['status']);
                }
                if ($search_params['telephone'] != null) {
                    $orders->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
                }

                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $orders->whereBetween('created_at', [$date[0], $date[1]]);
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
                ->editColumn('created_at', function ($order) {
                    return [
                        'display' => e(
                            $order->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $order->created_at->timestamp
                    ];
                })
                ->editColumn('order_date', function ($order) {
                    if ($order->order_date) {
                        $date = Carbon::parse($order->order_date);
                        return $date->format('Y-m-d');
                    }

                })
                ->editColumn('order_time', function ($order) {

                    if ($order->order_date) {
                        $date = Carbon::parse($order->order_date);
                        return $date->format('H:i');
                    }


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

                    $editBtn = '<a href="' . route('orders.edit', ['order' => $order->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateorder">
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


                    return $editBtn . $removeBtn;
                })
                ->rawColumns(['action', 'active', 'order_name', 'employee_name', 'telephone'])
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
        $createView = view('orders.order1_modal', [

             'cities' => $cities
            , 'order_type' => $order_type
            , 'status' => $status
            , 'EMPLOYEES' => $EMPLOYEES

        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }

    public function create2(Request $request)
    {

        $createView = view('orders.order2_modal', [


        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }
    public function address(Request $request)
    {

        $createView = view('orders.address_modal', [


        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }
    public function create3(Request $request)
    {

        $createView = view('orders.order3_modal', [


        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
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
            if ($request->order_date != null)
                $order_date = $request->order_date . ' ' . $request->order_time . ':00';
            else
                $order_date = null;
            $newOrder->order_date = $order_date;


        } else {
            $newOrder = Order::create($request->all());
            if ($request->order_date != null)
                $order_date = $request->order_date . ' ' . $request->order_time . ':00';
            else
                $order_date = null;
            $newOrder->order_date = $order_date;

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

        if ($request->updateEmployee == 1)
            $createView = view('orders.editEmployee_modal', [

                    'order' => $order
                    , 'EMPLOYEES' => $EMPLOYEES

                ]


            )->render();
        else if ($request->updateAnswer == 1)
            $createView = view('orders.answer_modal', [

                    'order' => $order


                ]


            )->render();
        else
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




