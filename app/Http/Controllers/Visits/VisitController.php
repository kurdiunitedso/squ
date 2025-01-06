<?php

namespace App\Http\Controllers\Visits;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\VisitExport;
use App\Exports\VisitsExport;
use App\Http\Controllers\Controller;
use App\Models\ClientCallAction;
use App\Models\Visit;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;
use App\Models\Facility;
use App\Models\Lead;
use App\Models\SystemSmsNotification;
use App\Models\User;
use App\Models\VisitRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VisitController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $cities = City::all();
            $EMPLOYEES = User::all();
            $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
            $category = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_category)->get();
            $status = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::status)->get();
            $rating = DropDownFields::rating;
            return view('visits.index', [
                'period' => $period,
                'category' => $category,
                'cities' => $cities,
                'status' => $status,
                'rating' => $rating,
                'EMPLOYEES' => $EMPLOYEES
            ]);
        }
        if ($request->isMethod('POST')) {
            $visits = Visit::with('cities', 'categories', 'priorities', 'visit_types', 'periods', 'statuses', 'employees');

            //return  $visits->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('city_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['city_id']);
                    if (count($results) > 0)
                        $visits->whereIn('city_id', $results);
                }
                if (array_key_exists('source', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['source']);
                    if (count($results) > 0)
                        $visits->whereIn('source', $results);
                }
                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $visits->whereIn('status', $results);
                }
                if (array_key_exists('category', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['category']);
                    if (count($results) > 0)
                        $visits->whereIn('category', $results);
                }

                if (array_key_exists('period', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['period']);
                    if (count($results) > 0)
                        $visits->whereIn('period', $results);
                }
                if (array_key_exists('rate_company', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['rate_company']);
                    if (count($results) > 0)
                        $visits->whereIn('rate_company', $results);
                }
                if (array_key_exists('rate_captin', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['rate_captin']);
                    if (count($results) > 0)
                        $visits->whereIn('rate_captin', $results);
                }
                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $visits->whereIn('status', $results);
                }


                if ($search_params['telephone'] != null) {
                    $visits->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
                }

                if ($search_params['visit_date'] != null) {
                    $date = explode('to', $search_params['visit_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $visits->whereBetween('visit_date', [$date[0], $date[1]]);
                }
            }

            //return $visits->get();
            return DataTables::eloquent($visits)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[5]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('visit_name', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('visit_date', function ($visit) {
                    if ($visit->visit_date) {
                        $date = Carbon::parse($visit->visit_date);
                        return $date->format('Y-m-d');
                    }
                })
                ->editColumn('since', function ($visit) {
                    if ($visit->visit_date) {
                        $date = Carbon::parse($visit->visit_date . " " . $visit->time);
                        return $date->diffForHumans();
                    }
                })
                ->editColumn('visit_name', function ($visit) {
                    if ($visit->visit_name)
                        return '<a href="' . route('visits.edit', ['visit' => $visit->id]) . '?updateAnswer=1" size="modal-xl" class="btnUpdatevisit" >' . $visit->visit_name . ' </a>';
                    else
                        return 'NA';
                })
                ->editColumn('visit_number', function ($visit) {
                    if ($visit->visit_number)
                        return '<a href="' . route('visits.edit', ['visit' => $visit->id]) . '?updateAnswer=1" size="modal-xl" class="btnUpdatevisit" >' . $visit->visit_number . ' </a>';
                    else
                        return 'NA';
                })
                ->editColumn('employee_name', function ($visit) {
                    if ($visit->employees)
                        return '<a href="' . route('visits.edit', ['visit' => $visit->id]) . '?updateEmployee=1" size="modal-sm" class="btnUpdatevisit" >' . $visit->employees->name . ' </a>';
                    else
                        return 'NA';
                })
                ->editColumn('rate_company', function ($visit) {
                    return '
                  <div class="rating">
                            <div class="rating-label ' . ($visit->rate_company >= 1 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 2 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 3 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 4 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 5 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                        </div>';
                })
                ->editColumn('rate_captin', function ($visit) {
                    return '
                                        <div class="rating">
                            <div class="rating-label ' . ($visit->rate_captin >= 1 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_captin >= 2 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_captin >= 3 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_captin >= 4 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_captin >= 5 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                        </div>';
                })
                ->addColumn('action', function ($visit) {
                    $editBtn = $smsAction = $callAction = $menu = '';
                    if (Auth::user()->canAny(['visit_edit'])) {
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

                    $editBtn = '<a href="' . route('visits.edit', ['visit' => $visit->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatevisit" size="modal-xl">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-visit-name="' . $visit->name . '" href=' . route('visits.delete', ['visit' => $visit->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletevisit"
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
                // ->rawColumns(['action', 'active', 'visit_name', 'employee_name', 'telephone', 'rate_company', 'rate_captin'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function indexByPhone(Request $request)
    {

        if ($request->isMethod('POST')) {
            $telephone = $request->telephone;
            $id = $request->id;
            if (!$id && !$telephone)
                return [];
            $visits = Visit::with('cities', 'categories', 'priorities', 'visit_types', 'periods', 'statuses', 'employees');
            if ($telephone)
                $visits = $visits->where('telephone', 'like', '%' . substr($telephone, -9) . '%');
            if ($id)
                $visits = $visits->where('visit_request_id', $id);
            return DataTables::eloquent($visits)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[5]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('visit_name', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('visit_date', function ($visit) {
                    if ($visit->visit_date) {
                        $date = Carbon::parse($visit->visit_date);
                        return $date->format('Y-m-d');
                    }
                })
                ->editColumn('since', function ($visit) {
                    if ($visit->visit_date) {
                        $date = Carbon::parse($visit->visit_date . " " . $visit->time);
                        return $date->diffForHumans();
                    }
                })
                ->editColumn('visit_name', function ($visit) {

                    return $visit->visit_name;
                })
                ->editColumn('visit_number', function ($visit) {
                    return $visit->visit_number;
                })
                ->editColumn('employee_name', function ($visit) {
                    if ($visit->employees)
                        return $visit->employees->name;
                })
                ->editColumn('rate_company', function ($visit) {
                    return '
                  <div class="rating">
                            <div class="rating-label ' . ($visit->rate_company >= 1 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 2 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 3 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 4 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                            <div class="rating-label ' . ($visit->rate_company >= 5 ? 'checked' : '') . '">
                                <i class="ki-duotone ki-star fs-1"></i>
                            </div>
                        </div>';
                })
                ->editColumn('rate_captin', function ($visit) {
                    return '
                  <div class="rating">
                                    <div class="rating-label ' . ($visit->rate_captin >= 1 ? 'checked' : '') . '">
                                        <i class="ki-duotone ki-star fs-1"></i>
                                    </div>
                                    <div class="rating-label ' . ($visit->rate_captin >= 2 ? 'checked' : '') . '">
                                        <i class="ki-duotone ki-star fs-1"></i>
                                    </div>
                                    <div class="rating-label ' . ($visit->rate_captin >= 3 ? 'checked' : '') . '">
                                        <i class="ki-duotone ki-star fs-1"></i>
                                    </div>
                                    <div class="rating-label ' . ($visit->rate_captin >= 4 ? 'checked' : '') . '">
                                        <i class="ki-duotone ki-star fs-1"></i>
                                    </div>
                                    <div class="rating-label ' . ($visit->rate_captin >= 5 ? 'checked' : '') . '">
                                        <i class="ki-duotone ki-star fs-1"></i>
                                    </div>
                                </div>';
                })

                // ->rawColumns(['action', 'active', 'visit_name', 'employee_name', 'telephone', 'rate_company', 'rate_captin'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $cities = City::all();
        $EMPLOYEES = User::all();
        if ($request->visit_request_id)
            $visitRequest = VisitRequest::find($request->visit_request_id);
        else
            $visitRequest = null;
        // dd($visitRequest->visitable_type == Facility::class);
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
        $category = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_category)->get();
        $visit_type = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_type)->get();
        $purpose = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::purpose)->get();
        $ticket_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::ticket_type)->get();
        $status = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::status)->get();
        $rating = DropDownFields::rating;
        // $motor_cc=DropDownFields::MOTOR_CC;
        //return $visitRequest;
        $call = ClientCallAction::find($request->call_id);
        $viewStr = ($visitRequest->visitable_type == Facility::class) ? 'trillionz_visits_addedit_modal' : 'wheels_visits_addedit_modal';
        $createView = view("visits.$viewStr", [
            'period' => $period,
            'TYPES' => Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)
                ->get(),

            'category' => $category,
            'cities' => $cities,
            'visit_type' => $visit_type,
            'status' => $status,
            'purpose' => $purpose,
            'ticket_type' => $ticket_type,
            'rating' => $rating,
            'visitRequest' => $visitRequest,
            'call' => $call,
            'EMPLOYEES' => $EMPLOYEES

        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }


    public function Visit(Request $request, $Id = null)
    {
        $data = $request->all();
        //return $request->all();
        if ($request->updateEmployee && isset($Id)) {
            $newVisit = Visit::find($Id);
            $newVisit->update($request->all());
            if ($request->ajax())
                return response()->json(['status' => true, 'message' => 'Visit has been added successfully!']);
        }

        /*  $request->validate([
              'visit_name' => 'required',

          ]);*/
        if (isset($Id)) {
            $newVisit = Visit::find($Id);
            $newVisit->update($request->all());
        } else {
            $visit_request = VisitRequest::findOrFail($request->visit_request_id);
            $data = collect($visit_request->toArray())
                ->merge($request->all())
                ->except(['created_at', 'updated_at', 'deleted_at'])
                ->merge([
                    'active' => $request->has('active_c'),
                    'wheels' => $request->has('wheel_c'),
                    'has_agency' => $request->has('has_agency_c'),
                    'intersted' => $request->has('intersted_c'),
                    'facility_id' => $visit_request->visitable_id,
                ])
                ->toArray();
            // dd($data);s
            if ($visit_request->visitable_type == Facility::class) {
                $lead = Lead::create($data); // Trillionz Visit
            } else {
                $data['status'] = 266;
                $newVisit = Visit::create($data); // Wheels Visit
            }
            // dd($data);
        }

        // $newVisit->save();

        $message = t('Visit has been added successfully!');
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => $message]);
        else
            return redirect()->route('visits.index', [
                'Id' => $newVisit->id,
                //'visit' => $newVisit->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Visit $visit)
    {
        $cities = City::all();
        $EMPLOYEES = User::all();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
        $purpose = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::purpose)->get();
        $category = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_category)->get();
        $status = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::status)->get();
        $ticket_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::ticket_type)->get();
        $visit_type = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_type)->get();
        $rating = DropDownFields::rating;
        if ($request->updateEmployee == 1)
            $createView = view(
                'visits.editEmployee_modal',
                [

                    'visit' => $visit,
                    'EMPLOYEES' => $EMPLOYEES

                ]


            )->render();
        else if ($request->updateAnswer == 1)
            $createView = view(
                'visits.answer_modal',
                [

                    'visit' => $visit


                ]


            )->render();
        else
            $createView = view(
                'visits.addedit_modal',
                [
                    'period' => $period,
                    'period' => $period,
                    'category' => $category,
                    'cities' => $cities,
                    'visit' => $visit,
                    'rating' => $rating,
                    'purpose' => $purpose,
                    'ticket_type' => $ticket_type,
                    'visit_type' => $visit_type,
                    'status' => $status,
                    'EMPLOYEES' => $EMPLOYEES

                ]


            )->render();


        //return $createView;
        return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Visit $Visit)
    {
        $Visit->delete();
        return response()->json(['status' => true, 'message' => 'Visit Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*    $d= new VisitExport($request->all());
        return $d->view();*/
        return Excel::download(new VisitExport($request->all()), 'visits.xlsx');
    }
}
