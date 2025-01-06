<?php

namespace App\Http\Controllers\Facility;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\FacilitiesExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\ClientCallAction;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Facility;
use App\Models\FacilityBranch;
use App\Models\FacilityEmployee;
use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class FacilityController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $countries = Country::all();
            $cities = City::all();
            $pos_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
            $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
            $printer_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
            $sys_satisfaction_rate = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();

            $type_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
            $category_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
            $preparation_time = DropDownFields::PREPARATION_TIME;
            return view('facilities.index', [
                'countries' => $countries,
                'cities' => $cities,
                'BANKS' => $BANKS,
                'printer_type' => $printer_type,
                'sys_satisfaction_rate' => $sys_satisfaction_rate,
                'facilityCategorys' => $category_id,
                'facilityTypes' => $type_id,
                'preparation_time' => $preparation_time,
                'posTypes' => $pos_type
            ]);
        }
        if ($request->isMethod('POST')) {
            $facilities = Facility::with('country', 'city', 'posType', 'type', 'category')->withCount('tickets')->withCount('visits')->withCount('attachments')->withCount('employees')->withCount('branches');

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('country_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['country_id']);
                    if (count($results) > 0)
                        $facilities->whereIn('country_id', $results);
                }
                if (array_key_exists('city_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['city_id']);
                    if (count($results) > 0)
                        $facilities->whereIn('city_id', $results);
                }
                if (array_key_exists('category_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['category_id']);
                    if (count($results) > 0)
                        $facilities->whereIn('category_id', $results);
                }
                if (array_key_exists('type_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type_id']);
                    if (count($results) > 0)
                        $facilities->whereIn('type_id', $results);
                }


                if (array_key_exists('pos_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['pos_type']);
                    if (count($results) > 0)
                        $facilities->whereIn('pos_type', $results);
                }


                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $facilities->where('active', $status);
                }
                if ($search_params['has_bot'] != null) {
                    $status = $search_params['has_bot'] == "YES" ? 1 : 0;
                    $facilities->where('has_wheels_bot', $status);
                }
                if ($search_params['has_b2b'] != null) {
                    $status = $search_params['has_b2b'] == "YES" ? 1 : 0;
                    $facilities->where('has_wheels_b2b', $status);
                }
                if ($search_params['has_pos'] != null) {
                    $status = $search_params['has_pos'] == "YES" ? 1 : 0;
                    $facilities->where('has_pos', $status);
                }
                if ($search_params['has_now'] != null) {
                    $status = $search_params['has_now'] == "YES" ? 1 : 0;
                    $facilities->where('has_wheels_now', $status);
                }
                if ($search_params['has_marketing'] != null) {
                    $status = $search_params['has_marketing'] == "YES" ? 1 : 0;
                    $facilities->where('has_marketing', $status);
                }
                if ($search_params['has_now'] != null) {
                    $status = $search_params['has_now'] == "YES" ? 1 : 0;
                    $facilities->where('has_wheels_now', $status);
                }
                if ($search_params['has_menu'] != null) {
                    $status = $search_params['has_menu'] == "YES" ? '>' : '=';
                    $facilities->where('items_count', $status, 0);
                }
                if ($search_params['has_employees'] != null) {
                    $status = $search_params['has_employees'] == "YES" ? '>' : '=';
                    $facilities->where('employees_count', $status, 0);
                }
                if ($search_params['has_branches'] != null) {
                    $status = $search_params['has_branches'] == "YES" ? '>' : '=';
                    $facilities->where('branches_count', $status, 0);
                }
                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $facilities->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orwhere('facility_id', 'like', "%" . $value . "%");
                        $q->orwhere('id_wheel', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                        //$q->orwhere(DB::raw('(select group_concat(facility_branches.telephone) from facility_branches where facility_branches.facility_id=facilities.id)'), 'like', "%" . $value . "%");
                        // $q->orwhere(DB::raw('(select group_concat(facility_employees.mobile) from facility_employees where facility_employees.facility_id=facilities.id)'), 'like', "%" . $value . "%");
                    });
                }
            }

            //return $facilities->get();
            return DataTables::eloquent($facilities)
                ->editColumn('created_at', function ($facility) {
                    return [
                        'display' => e(
                            $facility->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $facility->created_at->timestamp
                    ];
                })
                ->editColumn('has_client_trillions', function ($facility) {
                    return isset(optional(optional(optional($facility)->offer)->contract)->client_trillion)
                        ? '<h4 class="text text-success bold">Yes</h4>'
                        : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('name', function ($facility) {
                    return '<a href="' . route('facilities.edit', ['facility' => $facility->id]) . '" targer="_blank" class="">
                         ' . $facility->name . '
                    </a>';
                })
                ->editColumn('telephone', function ($facility) {
                    return '<a href="' . route('facilities.view_calls', ['facility' => $facility->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $facility->telephone .
                        '</a>';
                })
                ->editColumn('visits_count', function ($facility) {
                    return '<a href="' . route('facilities.view_visits', ['facility' => $facility->id]) . '?type=visits" class="viewCalls" title="show_visits">
                     ' . $facility->visits_count . '
                    </a>';
                })
                ->editColumn('tickets_count', function ($facility) {
                    return '<a href="' . route('facilities.view_tickets', ['facility' => $facility->id]) . '?type=tickets" class="viewCalls" title="show_tickets">
                     ' . $facility->tickets_count . '
                    </a>';
                })
                ->editColumn('branches_count', function ($facility) {
                    return '<a href="' . route('facilities.view_brnaches', ['facility' => $facility->id]) . '?type=brnaches" class="viewCalls" title="branches">
                     ' . $facility->branches_count . '
                    </a>';
                })
                ->editColumn('employees_count', function ($facility) {
                    return '<a href="' . route('facilities.view_employees', ['facility' => $facility->id]) . '?type=employees" class="viewCalls" title="employees">
                     ' . $facility->employees_count . '
                    </a>';
                })
                ->editColumn('attachments_count', function ($facility) {
                    return '<a href="' . route('facilities.view_attachments', ['facility' => $facility->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $facility->attachments_count . '
                    </a>';
                })
                ->editColumn('has_wheels_now', function ($facility) {
                    return $facility->has_wheels_now ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_wheels_bot', function ($facility) {
                    return $facility->has_wheels_bot ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_wheels_b2b', function ($facility) {
                    return $facility->has_wheels_b2b ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_marketing', function ($facility) {
                    return $facility->has_marketing ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('has_pos', function ($facility) {
                    return $facility->has_pos ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('active', function ($facility) {
                    return $facility->active ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->addColumn('action', function ($facility) {
                    return $facility->action_buttons;
                })
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $Countries = Country::all();

        $Types = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)
            ->get();
        $pos_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
        $OSTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::OS_TYPE)->get();
        $type_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $preparation_time = DropDownFields::PREPARATION_TIME;
        $printer_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
        $sys_satisfaction_rate = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $cities = City::all();
        $category_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
        $titles = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();
        $createView = view('facilities.addedit', [
            'Countries' => $Countries,
            'TYPES' => $Types,
            'cities' => $cities,
            'OSTYPES' => $OSTYPES,
            'preparation_time' => $preparation_time,
            'BANKS' => $BANKS,
            'CATEGORYS' => $category_id,
            'printer_type' => $printer_type,
            'sys_satisfaction_rate' => $sys_satisfaction_rate,
            'titles' => $titles,

            'PAYMENT_TYPES' => $PAYMENTTYPES,
            'facilityTypes' => $type_id,
            'posTypes' => $pos_type
        ])->render();
        return $createView;
    }


    public function Facility(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',
            /*    'type_id' => 'required',
                'pos_type' => 'required',*/
        ]);
        if (isset($Id)) {
            $newFacility = Facility::find($Id);
            $newFacility->update($request->all());
        } else
            $newFacility = Facility::create($request->all());


        // $newFacility->daily_orders_in_no = $request->daily_orders_in_no;


        if (Auth::user()->hasRole("super-admin")) {
            $newFacility->has_marketing = $request->has_marketing_active == 'on' ? 1 : 0;
            $newFacility->active = $request->active_active == 'on' ? 1 : 0;
            $newFacility->has_branch = $request->has_branch_active == 'on' ? 1 : 0;
            $newFacility->has_wheels_now = $request->has_wheels_now_active == 'on' ? 1 : 0;
            $newFacility->has_wheels_bot = $request->has_wheels_bot_active == 'on' ? 1 : 0;
            $newFacility->has_wheels_b2b = $request->has_wheels_b2b_active == 'on' ? 1 : 0;
            $newFacility->has_marketing_center = $request->has_marketing_center_active ? 1 : 0;
        }

        $newFacility->country_id = 1;
        $newFacility->city_id = 2;
        // $newFacility->telephone = 2;


        $newFacility->save();
        $message = 'Facility has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Facility has been added successfully!']);
        else
            return redirect()->route('facilities.index', [
                'Id' => $newFacility->id,
                'facility' => $newFacility->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Facility $facility)
    {

        $Countries = Country::all();
        $Types = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)
            ->get();
        $pos_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
        $OSTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::OS_TYPE)->get();
        $titles = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();
        $type_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $preparation_time = DropDownFields::PREPARATION_TIME;
        $printer_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
        $sys_satisfaction_rate = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $audits = $facility->audits()->with('user')->orderByDesc('created_at')->get();
        $category_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($facility) {
            $query->where('attachable_type', Facility::class)
                ->where('attachable_id', $facility->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        // return $preparation_time;
        $cities = City::all();
        $createView = view('facilities.addedit', [
            'Countries' => $Countries,
            'TYPES' => $Types,
            'cities' => $cities,
            'facility' => $facility,
            'CATEGORYS' => $category_id,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
            'OSTYPES' => $OSTYPES,
            'preparation_time' => $preparation_time,
            'BANKS' => $BANKS,
            'printer_type' => $printer_type,
            'sys_satisfaction_rate' => $sys_satisfaction_rate,
            'titles' => $titles,
            'PAYMENT_TYPES' => $PAYMENTTYPES,
            'facilityTypes' => $type_id,
            'posTypes' => $pos_type
        ])->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Facility $Facility)
    {
        $Facility->delete();
        return response()->json(['status' => true, 'message' => 'Facility Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*$r= new FacilitiesExport($request->all());
        return $r->view();*/
        return Excel::download(new FacilitiesExport($request->all()), 'facilities.xlsx');
    }

    /*  public function viewCalls(Request $request, Facility $facility)
      {
          $branches = FacilityBranch::where('facility_id', $facility->id)->get();
          //return $branches;
          $callsView = view('facilities.viewCalls'
              , [
                  'branches' => $branches,
                  'facility' => $facility,

              ])->render();
          return response()->json(['callsView' => $callsView]);
      }*/
    public function viewCalls(Request $request, Facility $facility)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($facility->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($facility->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($facility->telephone, -9) . '%')->get();
        $callsView = view(
            'facilities.viewCalls',
            [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'facility' => $facility,

            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }


    public function viewBrnaches(Request $request, Facility $facility)
    {

        $callsView = view(
            'facilities.viewBrnaches',
            [
                'facility' => $facility,
            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewItems(Request $request, Facility $facility)
    {

        $callsView = view(
            'facilities.viewItems',
            [
                'facility' => $facility,

            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewTickets(Request $request, Facility $facility)
    {

        $callsView = view(
            'facilities.viewTickets',
            [
                'facility' => $facility,

            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewVisits(Request $request, Facility $facility)
    {

        $callsView = view(
            'facilities.viewVisits',
            [
                'facility' => $facility,

            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }


    public function viewAttachments(Request $request, Facility $facility)
    {

        $callsView = view(
            'facilities.viewAttachments',
            [
                'facility' => $facility,

            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }

    public function viewEmployees(Request $request, Facility $facility)
    {
        $titles = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();

        $callsView = view(
            'facilities.viewEmployees',
            [
                'titles' => $titles,

                'facility' => $facility,

            ]
        )->render();
        return response()->json(['callsView' => $callsView]);
    }
}
