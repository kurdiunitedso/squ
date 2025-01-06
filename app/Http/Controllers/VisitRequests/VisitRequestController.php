<?php

namespace App\Http\Controllers\VisitRequests;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\VisitExport;
use App\Exports\VisitRequestsExport;
use App\Http\Controllers\Controller;
use App\Models\Captin;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientTrillion;
use App\Models\EmployeeProject;
use App\Models\Facility;
use App\Models\Restaurant;
use App\Models\Visit;
use App\Models\CdrLog;

use App\Models\Constant;

use App\Models\SystemSmsNotification;
use App\Models\User;
use App\Models\VisitRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VisitRequestController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            $EMPLOYEES = User::all();
            $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
            $category = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_category)->get();
            $status = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::status)->get();
            $projects = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::perject)->get();
            $rating = DropDownFields::rating;
            return view('visitRequests.index', [
                'period' => $period
                , 'category' => $category
                , 'projects' => $projects
                , 'status' => $status
                , 'rating' => $rating
                , 'EMPLOYEES' => $EMPLOYEES
            ]);
        }
        if ($request->isMethod('POST')) {
            $visits = VisitRequest::with('categories', 'priorities', 'visit_types', 'statuses', 'employees')
                ->withCount('visits');

            //return  $visits->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $visits->whereIn('status', $results);

                }

                if (array_key_exists('employee_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['employee_id']);
                    if (count($results) > 0)
                        $visits->whereIn('employee', $results);

                }

                if (array_key_exists('project_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['project_id']);
                    if (count($results) > 0) {
                        $visits->whereHas('employees', function ($subQuery) use ($results) {
                            $subQuery->wherein('id', EmployeeProject::wherein('project_id', $results)->pluck('employee_id')->toArray());

                        });
                    }
                }


                if (array_key_exists('category', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['category']);
                    if (count($results) > 0)
                        $visits->whereIn('visit_category', $results);

                }


                if ($search_params['telephone'] != null) {
                    $visits->where('telephone', 'like', '%' . $search_params['telephone'] . '%');
                }

                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $visits->whereBetween('created_at', [$date[0], $date[1]]);
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
                ->editColumn('last_date', function ($visit) {
                    if ($visit->last_date) {
                        $date = Carbon::parse($visit->last_date);
                        return $date->format('Y-m-d');
                    }

                })
                ->editColumn('visitable_type', function ($visit) {
                    $class = str_replace('App\\Models\\', '', $visit->visitable_type);
                    if ($visit->visitable_type) {
                        $C = $visit->visitable_type;
                        //return $C;
                        $model = $C::find($visit->visitable_id);
                        if ($model) {
                            if ($class == 'Facility')
                                return '<a href="' . route('facilities.edit', [strtolower($class) => $model->id]) . '?updateEmployee=1" target="_blank" >' . $class . '-' . $model->id . ' </a>';
                            else
                                return '<a href="' . route(strtolower($class) . 's.edit', [strtolower($class) => $model->id]) . '?updateEmployee=1" target="_blank" >' . $class . '-' . $model->id . ' </a>';
                        }
                    }
                    return 'NA';
                    //$class= Relation::getMorphedModel($visit->visitable_type);
                    //return $class?$class->id:'NA';
                })
                ->editColumn('visits_count', function ($visit) {
                    return '<a href="' . route('visitRequests.view_visits', ['visit' => $visit->id]) . '?type=visits" class="viewCalls" title="show_visits">
                     ' . $visit->visits_count . '
                    </a>';
                })
                ->editColumn('employee_name', function ($visit) {
                    if ($visit->employees)
                        return '<a href="' . route('visitRequests.edit', ['visit' => $visit->id]) . '?updateEmployee=1" class="btnUpdatevisit" >' . $visit->employees->name . ' </a>';
                    else
                        return 'NA';

                })
                ->editColumn('telephone', function ($visit) {
                    /* return '<a href="' . route('visitRequests.view_calls', ['visit' => $visit->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                         . $visit->telephone .
                         '</a>';*/
                    return $visit->telephone;
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

                    $editBtn = '<a href="' . route('visitRequests.edit', ['visit' => $visit->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatevisit">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-visit-name="' . $visit->name . '" href=' . route('visitRequests.delete', ['visit' => $visit->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletevisit"
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

                    $creatVisit = '  <button type="button" url="' . route('visits.create') . '?telephone=' . $visit->telephone . '$visit=' . $visit->name . '&visit_request_id=' . $visit->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" id="AddvisitsModal">
                                <span class="indicator-label">
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                  rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                  fill="currentColor"/>
                                        </svg>
                                    </span>
                                </span>

                            </button>';
                    $createLead = '  <button type="button" url="' . route('leads.create') . '?telephone=' . $visit->telephone . '$visit=' . $visit->name . '&visit_request_id=' . $visit->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" id="AddleadsModal">
                                <span class="indicator-label">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Create Lead</title>
    <desc>Create Lead</desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#999" fill-rule="nonzero" opacity="0.3"/>
        <path d="M12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.98630124,11 4.48466491,11.0516454 4,11.1500272 L4,7 C4,5.8954305 4.8954305,5 6,5 L20,5 C21.1045695,5 22,5.8954305 22,7 L22,16 C22,17.1045695 21.1045695,18 20,18 L12.9835977,18 Z M19.1444251,6.83964668 L13,10.1481833 L6.85557487,6.83964668 C6.4908718,6.6432681 6.03602525,6.77972206 5.83964668,7.14442513 C5.6432681,7.5091282 5.77972206,7.96397475 6.14442513,8.16035332 L12.6444251,11.6603533 C12.8664074,11.7798822 13.1335926,11.7798822 13.3555749,11.6603533 L19.8555749,8.16035332 C20.2202779,7.96397475 20.3567319,7.5091282 20.1603533,7.14442513 C19.9639747,6.77972206 19.5091282,6.6432681 19.1444251,6.83964668 Z" fill="#999"/>
    </g>
</svg>
                                    </span>
                                </span>

                            </button>';

                    return $editBtn . $removeBtn . $creatVisit . $createLead;
                })
                //->rawColumns(['action', 'active', 'employee_name', 'telephone', 'last_date'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {

        $cities = City::all();
        $EMPLOYEES = User::all();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();
        $category = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_category)->get();
        $visit_type = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_type)->get();
        $purpose = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::purpose)->get();
        $status = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::status)->get();
        $ticket_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::ticket_type)->get();
        $rating = DropDownFields::rating;
        $selectedCaptins = $request->selectedCaptins;
        $selectedClients = $request->selectedClients;
        $selectedClientTrillions = $request->selectedClientTrillions;
        $selectedFacilities = $request->selectedFacilities;
        $visit_category = $request->visit_category;
        $selectedRestaurants = $request->selectedRestaurants;
        $captins = explode(',', $request->selectedCaptins);
        $clients = explode(',', $request->selectedClients);
        $clientTrillions = explode(',', $request->selectedClientTrillions);
        $facilities = explode(',', $request->selectedFacilities);
        $restaurants = explode(',', $request->selectedRestaurants);
        $names = "";
        if (count($this->filterArrayForNullValues($captins)) > 0)
            $names .= Captin::select(DB::raw('GROUP_CONCAT(name,"-",mobile1) as names'))->wherein('id', $captins)->get()->first() ? Captin::select(DB::raw('GROUP_CONCAT(name,"-",mobile1) as names'))->wherein('id', $captins)->get()->first()->names : '';
        else if (count($this->filterArrayForNullValues($restaurants)) > 0)
            $names .= Restaurant::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $restaurants)->get()->first() ? Restaurant::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $restaurants)->get()->first()->names : '';
        else if (count($this->filterArrayForNullValues($clients)) > 0)
            $names .= Client::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $clients)->get()->first() ? Client::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $clients)->get()->first()->names : '';
        else if (count($this->filterArrayForNullValues($clientTrillions)) > 0)
            $names .= ClientTrillion::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $clientTrillions)->get()->first() ? ClientTrillion::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $clientTrillions)->get()->first()->names : '';
        else if (count($this->filterArrayForNullValues($facilities)) > 0)
            $names .= Facility::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $facilities)->get()->first() ? Facility::select(DB::raw('GROUP_CONCAT(name,"-",telephone) as names'))->wherein('id', $facilities)->get()->first()->names : '';
        else
            $names = "";

        // $names = 'hhh';
        // $names = 'hhh';
        // $motor_cc=DropDownFields::MOTOR_CC;
        $createView = view('visitRequests.addedit_modal', [
            'period' => $period,
            'period' => $period
            , 'ticket_type' => $ticket_type
            , 'category' => $category
            , 'names' => $names
            , 'purpose' => $purpose
            , 'cities' => $cities
            , 'selectedCaptins' => $selectedCaptins
            , 'selectedRestaurants' => $selectedRestaurants
            , 'selectedClients' => $selectedClients
            , 'selectedClientTrillions' => $selectedClientTrillions
            , 'selectedFacilities' => $selectedFacilities
            , 'visit_type' => $visit_type
            , 'status' => $status
            , 'visit_category' => $visit_category
            , 'rating' => $rating
            , 'EMPLOYEES' => $EMPLOYEES

        ])->render();

        return response()->json(['createView' => $createView]);
        //return $createView;
    }


    public function VisitRequest(Request $request, $Id = null)
    {
        //return $request->all();
        if ($request->updateEmployee && isset($Id)) {
            $newVisit = VisitRequest::find($Id);
            $newVisit->update($request->all());
            if ($request->ajax())
                return response()->json(['status' => true, 'message' => 'Visit has been added successfully!']);
        }

        /*   $request->validate([
               //'visit_name' => 'required',
               // 'purpose' => 'required',
                //'visit_type' => 'required',
               // 'department' => 'required',
               // 'last_date' => 'required',
               // 'employee' => 'required',
               // 'details' => 'required',
           ]);*/
        if (isset($Id)) {
            $newVisit = VisitRequest::find($Id);
            $newVisit->update($request->all());


        } else {
            if ($request->selectedCaptins) {

                $selectedCaptins = explode(',', $request->selectedCaptins);
                $count = count($selectedCaptins);
                foreach ($selectedCaptins as $k => $v) {
                    $captin = Captin::find($v);
                    $newVisit = VisitRequest::create($request->all());
                    $newVisit->telephone = $captin->mobile1;
                    $newVisit->requester = Auth::user()->id;
                    $newVisit->status = $request->status ? $request->status : 266;
                    $newVisit->city_id = $captin->city_id;;
                    $newVisit->visit_name = $captin->name;
                    $newVisit->save();
                    $captin->visits()->save($newVisit);

                }
                if ($request->ajax())
                    return response()->json(['status' => true, 'message' => 'Request Visists ' . $count . ' has been added successfully!']);
            } elseif ($request->selectedRestaurants) {

                $selectedRestaurants = explode(',', $request->selectedRestaurants);
                $count = count($selectedRestaurants);
                foreach ($selectedRestaurants as $k => $v) {
                    $restaurant = Restaurant::find($v);
                    $newVisit = VisitRequest::create($request->all());
                    $newVisit->telephone = $restaurant->telephone;
                    $newVisit->requester = Auth::user()->id;
                    $newVisit->status = $request->status ? $request->status : 266;
                    $newVisit->city_id = $restaurant->city_id;;
                    $newVisit->visit_name = $restaurant->name;

                    $newVisit->save();
                    $restaurant->visits()->save($newVisit);

                }
                if ($request->ajax())
                    return response()->json(['status' => true, 'message' => 'Request Visists ' . $count . ' has been added successfully!']);
            } elseif ($request->selectedClients) {

                $selectedClients = explode(',', $request->selectedClients);
                $count = count($selectedClients);
                foreach ($selectedClients as $k => $v) {
                    $client = Client::find($v);
                    $newVisit = VisitRequest::create($request->all());
                    $newVisit->telephone = $client->telephone;
                    $newVisit->requester = Auth::user()->id;
                    $newVisit->status = $request->status ? $request->status : 266;
                    $newVisit->city_id = $client->city_id;;
                    $newVisit->visit_name = $client->name;

                    $newVisit->save();
                    $client->visits()->save($newVisit);

                }
                if ($request->ajax())
                    return response()->json(['status' => true, 'message' => 'Request Visists ' . $count . ' has been added successfully!']);
            } elseif ($request->selectedClientTrillions) {

                $selectedClientTrillions = explode(',', $request->selectedClientTrillions);
                $count = count($selectedClientTrillions);
                foreach ($selectedClientTrillions as $k => $v) {
                    $client = ClientTrillion::find($v);
                    $newVisit = VisitRequest::create($request->all());
                    $newVisit->telephone = $client->telephone;
                    $newVisit->requester = Auth::user()->id;
                    $newVisit->status = $request->status ? $request->status : 266;
                    $newVisit->city_id = $client->city_id;;
                    $newVisit->visit_name = $client->name;

                    $newVisit->save();
                    $client->visits()->save($newVisit);

                }
                if ($request->ajax())
                    return response()->json(['status' => true, 'message' => 'Request Visists ' . $count . ' has been added successfully!']);
            } elseif ($request->selectedFacilities) {

                $selectedFacilities = explode(',', $request->selectedFacilities);
                $count = count($selectedFacilities);
                foreach ($selectedFacilities as $k => $v) {
                    $client = Facility::find($v);
                    $newVisit = VisitRequest::create($request->all());
                    $newVisit->telephone = $client->telephone;
                    $newVisit->requester = Auth::user()->id;
                    $newVisit->status = $request->status ? $request->status : 266;
                    $newVisit->city_id = $client->city_id;;
                    $newVisit->visit_name = $client->name;

                    $newVisit->save();
                    $client->visits()->save($newVisit);

                }
                if ($request->ajax())
                    return response()->json(['status' => true, 'message' => 'Request Visists ' . $count . ' has been added successfully!']);
            } else
                $newVisit = VisitRequest::create($request->all());


        }

        $newVisit->save();

        $message = 'Visit has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Visit has been added successfully!']);
        else
            return redirect()->route('visitRequests.index', [
                'Id' => $newVisit->id,
                //'visit' => $newVisit->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, VisitRequest $visit)
    {

        $EMPLOYEES = User::all();
        $cities = City::all();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();

        $ticket_type = Constant::where('module', Modules::TICKET)->where('field', DropDownFields::ticket_type)->get();
        $period = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::period)->get();

        $purpose = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::purpose)->get();
        $category = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_category)->get();
        $status = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::status)->get();
        $visit_type = Constant::where('module', Modules::VISIT)->where('field', DropDownFields::visit_type)->get();
        $rating = DropDownFields::rating;
        if ($request->updateEmployee == 1)
            $createView = view('visitRequests.editEmployee_modal', [

                    'visit' => $visit
                    , 'EMPLOYEES' => $EMPLOYEES
                    , 'status' => $status
                ]


            )->render();
        else if ($request->updateAnswer == 1)
            $createView = view('visitRequests.answer_modal', [

                    'visit' => $visit
                    , 'status' => $status

                ]


            )->render();
        else
            $createView = view('visitRequests.addedit_modal', [
                    'period' => $period,
                    'category' => $category
                    , 'purpose' => $purpose
                    , 'visit' => $visit
                    , 'cities' => $cities
                    , 'ticket_type' => $ticket_type
                    , 'rating' => $rating
                    , 'selectedCaptins' => 0
                    , 'selectedRestaurants' => 0
                    , 'visit_type' => $visit_type
                    , 'status' => $status
                    , 'EMPLOYEES' => $EMPLOYEES

                ]


            )->render();


        //return $createView;
        return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, VisitRequest $Visit)
    {
        $Visit->delete();
        return response()->json(['status' => true, 'message' => 'Visit Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*    $d= new VisitExport($request->all());
            return $d->view();*/
        return Excel::download(new VisitRequestsExport($request->all()), 'visitReqs.xlsx');
    }

    public function viewVisits(Request $request, VisitRequest $visit)
    {

        $callsView = view('visitRequests.viewVisits'
            , [
                'visitRequest' => $visit,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }


}




