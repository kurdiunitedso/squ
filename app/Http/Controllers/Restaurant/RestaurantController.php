<?php

namespace App\Http\Controllers\Restaurant;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\RestaurantsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\ClientCallAction;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Restaurant;
use App\Models\RestaurantBranch;
use App\Models\RestaurantEmployee;
use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class RestaurantController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $countries = Country::all();
            $cities = City::all();
            $pos_type = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::POS_TYPE)->get();
            $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
            $printer_type = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::printer_type)->get();
            $sys_satisfaction_rate = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::sys_satisfaction_rat)->get();

            $type_id = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::RESTAURANT_TYPE)->get();
            $preparation_time = DropDownFields::PREPARATION_TIME;
            return view('restaurants.index', [
                'countries' => $countries,
                'cities' => $cities,
                'BANKS' => $BANKS,
                'printer_type' => $printer_type,
                'sys_satisfaction_rate' => $sys_satisfaction_rate,

                'restaurantTypes' => $type_id,
                'preparation_time' => $preparation_time,
                'posTypes' => $pos_type
            ]);
        }
        if ($request->isMethod('POST')) {
            $restaurants = Restaurant::with('country', 'city', 'posType', 'type')->withCount('tickets')->withCount('visits')->withCount('attachments')->withCount('employees')->withCount('branches');

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('country_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['country_id']);
                    if (count($results) > 0)
                        $restaurants->whereIn('country_id', $results);

                }
                if (array_key_exists('city_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['city_id']);
                    if (count($results) > 0)
                        $restaurants->whereIn('city_id', $results);

                }

                if (array_key_exists('type_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type_id']);
                    if (count($results) > 0)
                        $restaurants->whereIn('type_id', $results);

                }


                if (array_key_exists('pos_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['pos_type']);
                    if (count($results) > 0)
                        $restaurants->whereIn('pos_type', $results);

                }



                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $restaurants->where('active', $status);
                }
                if ($search_params['has_bot'] != null) {
                    $status = $search_params['has_bot'] == "YES" ? 1 : 0;
                    $restaurants->where('has_wheels_bot', $status);
                }
                if ($search_params['has_b2b'] != null) {
                    $status = $search_params['has_b2b'] == "YES" ? 1 : 0;
                    $restaurants->where('has_wheels_b2b', $status);
                }
                if ($search_params['has_pos'] != null) {
                    $status = $search_params['has_pos'] == "YES" ? 1 : 0;
                    $restaurants->where('has_pos', $status);
                }
                if ($search_params['has_now'] != null) {
                    $status = $search_params['has_now'] == "YES" ? 1 : 0;
                    $restaurants->where('has_wheels_now', $status);
                }
                if ($search_params['has_marketing'] != null) {
                    $status = $search_params['has_marketing'] == "YES" ? 1 : 0;
                    $restaurants->where('has_marketing', $status);
                }
                if ($search_params['has_now'] != null) {
                    $status = $search_params['has_now'] == "YES" ? 1 : 0;
                    $restaurants->where('has_wheels_now', $status);
                }
                if ($search_params['has_menu'] != null) {
                    $status = $search_params['has_menu'] == "YES" ? '>' : '=';
                    $restaurants->where('items_count', $status, 0);
                }
                if ($search_params['has_employees'] != null) {
                    $status = $search_params['has_employees'] == "YES" ? '>' : '=';
                    $restaurants->where('employees_count', $status, 0);
                }
                if ($search_params['has_branches'] != null) {
                    $status = $search_params['has_branches'] == "YES" ? '>' : '=';
                    $restaurants->where('branches_count', $status, 0);
                }
                if ($search_params['search'] != null) {
                    $value=$search_params['search'];
                    $restaurants->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orwhere('restaurant_id', 'like', "%" . $value . "%");
                        $q->orwhere('id_wheel', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                        //$q->orwhere(DB::raw('(select group_concat(restaurant_branches.telephone) from restaurant_branches where restaurant_branches.restaurant_id=restaurants.id)'), 'like', "%" . $value . "%");
                       // $q->orwhere(DB::raw('(select group_concat(restaurant_employees.mobile) from restaurant_employees where restaurant_employees.restaurant_id=restaurants.id)'), 'like', "%" . $value . "%");
                    });
                }


            }

            //return $restaurants->get();
            return DataTables::eloquent($restaurants)

                ->editColumn('created_at', function ($restaurant) {
                    return [
                        'display' => e(
                            $restaurant->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $restaurant->created_at->timestamp
                    ];
                })
                ->editColumn('name', function ($restaurant) {
                    return '<a href="' . route('restaurants.edit', ['restaurant' => $restaurant->id]) . '" targer="_blank" class="">
                         ' . $restaurant->name . '
                    </a>';
                })
                ->editColumn('telephone', function ($restaurant) {
                    return '<a href="' . route('restaurants.view_calls', ['restaurant' => $restaurant->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $restaurant->telephone .
                        '</a>';
                })

                ->editColumn('visits_count', function ($restaurant) {
                    return '<a href="' . route('restaurants.view_visits', ['restaurant' => $restaurant->id]) . '?type=visits" class="viewCalls" title="show_visits">
                     ' . $restaurant->visits_count . '
                    </a>';
                })

                ->editColumn('tickets_count', function ($restaurant) {
                    return '<a href="' . route('restaurants.view_tickets', ['restaurant' => $restaurant->id]) . '?type=tickets" class="viewCalls" title="show_tickets">
                     ' . $restaurant->tickets_count . '
                    </a>';
                })

                ->editColumn('branches_count', function ($restaurant) {
                    return '<a href="' . route('restaurants.view_brnaches', ['restaurant' => $restaurant->id]) . '?type=brnaches" class="viewCalls" title="branches">
                     ' . $restaurant->branches_count . '
                    </a>';
                })
                ->editColumn('employees_count', function ($restaurant) {
                    return '<a href="' . route('restaurants.view_employees', ['restaurant' => $restaurant->id]) . '?type=employees" class="viewCalls" title="employees">
                     ' . $restaurant->employees_count . '
                    </a>';
                })
                ->editColumn('attachments_count', function ($restaurant) {
                   return '<a href="' . route('restaurants.view_attachments', ['restaurant' => $restaurant->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $restaurant->attachments_count . '
                    </a>';
                })

                ->editColumn('has_wheels_now', function ($restaurant) {
                    return $restaurant->has_wheels_now ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_wheels_bot', function ($restaurant) {
                    return $restaurant->has_wheels_bot ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_wheels_b2b', function ($restaurant) {
                    return $restaurant->has_wheels_b2b ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_marketing', function ($restaurant) {
                    return $restaurant->has_marketing ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_pos', function ($restaurant) {
                    return $restaurant->has_pos ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('active', function ($restaurant) {
                    return $restaurant->active ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->addColumn('action', function ($restaurant) {
                    $editBtn = $removeBtn = $menu = '';

                    if (Auth::user()->can('restaurant_edit')) {
                        if (Auth::user()->canAny(['restaurant_edit'])) {
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

                            if (Auth::user()->can('restaurant_edit')) {

                                $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('restaurants.view_attachments', ['restaurant' => $restaurant->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                            Show Attachments (' . $restaurant->attachments_count . ')
                                        </a>
                                    </div>';
                            }


                            $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                        }

                        $creatVisit='  <button type="button" url="'. route('visitRequests.create').'?telephone='.$restaurant->telephone. '&selectedRestaurants=' . $restaurant->id .'&visit_name='.$restaurant->name.'&visit_category=249" class="btn btn-icon btn-active-light-primary w-30px h-30px" id="AddvisitsModal">
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
                        $editBtn = '<a href="' . route('restaurants.edit', ['restaurant' => $restaurant->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdaterestaurant">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                        $removeBtn = '<a data-restaurant-name="' . $restaurant->name . '" href=' . route('restaurants.delete', ['restaurant' => $restaurant->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleterestaurant"
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
                    }
                    return $editBtn.$creatVisit . $removeBtn . $menu;
                })
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $Countries = Country::all();
        $Types = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::RESTAURANT_TYPE)
            ->get();
        $pos_type = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::POS_TYPE)->get();
        $OSTYPES = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::OS_TYPE)->get();
        $type_id = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::RESTAURANT_TYPE)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $preparation_time = DropDownFields::PREPARATION_TIME;
        $printer_type = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::printer_type)->get();
        $sys_satisfaction_rate = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $cities = City::all();
        $titles = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::titles)->get();
        $createView = view('restaurants.addedit', ['Countries' => $Countries
            , 'TYPES' => $Types
            , 'cities' => $cities,
            'OSTYPES' => $OSTYPES,
            'preparation_time' => $preparation_time,
            'BANKS' => $BANKS,
            'printer_type' => $printer_type,
            'sys_satisfaction_rate' => $sys_satisfaction_rate,
            'titles'=>$titles,

            'PAYMENT_TYPES' => $PAYMENTTYPES,
            'restaurantTypes' => $type_id,
            'posTypes' => $pos_type])->render();
        return $createView;
    }


    public function Restaurant(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',
        /*    'type_id' => 'required',
            'pos_type' => 'required',*/
        ]);
        if (isset($Id))
            $newRestaurant = Restaurant::find($Id);
        else
            $newRestaurant = new Restaurant();
        $newRestaurant->name = $request->name;
        $newRestaurant->name_en = $request->name_en;
        $newRestaurant->type_id = $request->type_id;
        $newRestaurant->has_pos = $request->has_pos;
        $newRestaurant->has_call_center = $request->has_call_center;
        $newRestaurant->daily_orders_out_no = $request->daily_orders_out_no;
        $newRestaurant->need_internal_call_sys = $request->need_internal_call_sys;
        $newRestaurant->average_preparation_time =  $request->average_preparation_time;
        $newRestaurant->interst_to_market =  $request->interst_to_market;
        $newRestaurant->restaurant_id = $request->restaurant_id;
        $newRestaurant->pos_type = $request->pos_type;
        $newRestaurant->items_no = $request->items_no;
        $newRestaurant->os_type = $request->os_type;
        //$newRestaurant->total_sales_visa = $request->total_sales_visa;
        //$newRestaurant->total_sales_cash = $request->total_sales_cash;
        //$newRestaurant->total_orders = $request->total_orders;
        $newRestaurant->join_date = $request->join_date;
        $newRestaurant->commission_visa = $request->commission_visa;
        $newRestaurant->commission_cash = $request->commission_cash;
        $newRestaurant->bank_name = $request->bank_name;
        $newRestaurant->bank_branch = $request->bank_branch;
        $newRestaurant->payment_type = $request->payment_type;
        $newRestaurant->sys_satisfaction_rate = $request->sys_satisfaction_rate;

        $newRestaurant->printer_type = $request->printer_type;
        $newRestaurant->branch = $request->branch;
        $newRestaurant->email = $request->email;
        $newRestaurant->whatsapp = $request->whatsapp;
        $newRestaurant->box_no = $request->box_no;
        $newRestaurant->has_box = $request->has_box;
        $newRestaurant->telephone = $request->telephone;


        // $newRestaurant->daily_orders_in_no = $request->daily_orders_in_no;
        $newRestaurant->average_item_price = $request->average_item_price;


        $newRestaurant->cash = $request->cash;
        $newRestaurant->visa = $request->visa;
        $newRestaurant->iban = $request->iban;
        $newRestaurant->benficiary = $request->benficiary;
        if (Auth::user()->hasRole("super-admin")) {
            $newRestaurant->has_marketing = $request->has_marketing == 'on' ? 1 : 0;
            $newRestaurant->active = $request->active == 'on' ? 1 : 0;
            $newRestaurant->has_branch = $request->has_branch == 'on' ? 1 : 0;
            $newRestaurant->has_wheels_now = $request->has_wheels_now == 'on' ? 1 : 0;
            $newRestaurant->has_wheels_bot = $request->has_wheels_bot == 'on' ? 1 : 0;
            $newRestaurant->has_wheels_b2b = $request->has_wheels_b2b == 'on' ? 1 : 0;
            $newRestaurant->has_marketing_center = $request->has_marketing_center ? 1 : 0;
        }
        $newRestaurant->facebook_address = $request->facebook_address;
        $newRestaurant->tiktok_address = $request->tiktok_address;
        $newRestaurant->instagram_address = $request->instagram_address;

        $newRestaurant->marketing_rep_co_name = $request->marketing_rep_co_name;
        $newRestaurant->marketing_rep_name = $request->marketing_rep_name;
        $newRestaurant->pay_to_marketing_agent_amount = $request->pay_to_marketing_agent_amount;
        $newRestaurant->country_id = 1;
        $newRestaurant->city_id = 2;
       // $newRestaurant->telephone = 2;
        $newRestaurant->daily_orders_in_no = $request->items_no;

        $newRestaurant->save();
        $message = 'Restaurant has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Restaurant has been added successfully!']);
        else
            return redirect()->route('restaurants.index', [
                'Id' => $newRestaurant->id,
                'restaurant' => $newRestaurant->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Restaurant $restaurant)
    {

        $Countries = Country::all();
        $Types = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::RESTAURANT_TYPE)
            ->get();
        $pos_type = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::POS_TYPE)->get();
        $OSTYPES = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::OS_TYPE)->get();
        $titles = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::titles)->get();
        $type_id = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::RESTAURANT_TYPE)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $preparation_time = DropDownFields::PREPARATION_TIME;
        $printer_type = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::printer_type)->get();
        $sys_satisfaction_rate = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $audits = $restaurant->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($restaurant) {
            $query->where('attachable_type', Restaurant::class)
                ->where('attachable_id', $restaurant->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        // return $preparation_time;
        $cities = City::all();
        $createView = view('restaurants.addedit', ['Countries' => $Countries
            , 'TYPES' => $Types
            , 'cities' => $cities,
            'restaurant' => $restaurant,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
            'OSTYPES' => $OSTYPES,
            'preparation_time' => $preparation_time,
            'BANKS' => $BANKS,
            'printer_type' => $printer_type,
            'sys_satisfaction_rate' => $sys_satisfaction_rate,
'titles'=>$titles,
            'PAYMENT_TYPES' => $PAYMENTTYPES,
            'restaurantTypes' => $type_id,
            'posTypes' => $pos_type])->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Restaurant $Restaurant)
    {
        $Restaurant->delete();
        return response()->json(['status' => true, 'message' => 'Restaurant Deleted Successfully !']);
    }

    public function export(Request $request)
    {
/*$r= new RestaurantsExport($request->all());
return $r->view();*/
        return Excel::download(new RestaurantsExport($request->all()), 'restaurants.xlsx');
    }

  /*  public function viewCalls(Request $request, Restaurant $restaurant)
    {
        $branches = RestaurantBranch::where('restaurant_id', $restaurant->id)->get();
        //return $branches;
        $callsView = view('restaurants.viewCalls'
            , [
                'branches' => $branches,
                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }*/
    public function viewCalls(Request $request,  Restaurant $restaurant)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($restaurant->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($restaurant->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($restaurant->telephone, -9) . '%')->get();
        $callsView = view('restaurants.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }


    public function viewBrnaches(Request $request, Restaurant $restaurant)
    {

        $callsView = view('restaurants.viewBrnaches'
            , [
                'restaurant' => $restaurant,
            ])->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewItems(Request $request, Restaurant $restaurant)
    {

        $callsView = view('restaurants.viewItems'
            , [
                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewTickets(Request $request, Restaurant $restaurant)
    {

        $callsView = view('restaurants.viewTickets'
            , [
                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewVisits(Request $request, Restaurant $restaurant)
    {

        $callsView = view('restaurants.viewVisits'
            , [
                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }


    public function viewAttachments(Request $request, Restaurant $restaurant)
    {

        $callsView = view('restaurants.viewAttachments'
            , [
                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewEmployees(Request $request, Restaurant $restaurant)
    {
        $titles = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::titles)->get();

        $callsView = view('restaurants.viewEmployees'
            , [
                'titles'=>$titles,

                'restaurant' => $restaurant,

            ])->render();
        return response()->json(['callsView' => $callsView]);
    }


}
