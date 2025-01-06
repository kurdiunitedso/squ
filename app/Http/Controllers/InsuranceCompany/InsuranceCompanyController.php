<?php

namespace App\Http\Controllers\InsuranceCompany;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\InsuranceCompanysExport;
use App\Http\Controllers\Controller;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\ClientCallAction;
use App\Models\Constant;
use App\Models\Country;
use App\Models\InsuranceCompany;
use App\Models\InsuranceCompanyBranch;
use App\Models\InsuranceCompanyTeam;
use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class InsuranceCompanyController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $countries = Country::all();
            $cities = City::all();

            $BANKS = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::BANK)->get();

            $type_id = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::INSURANCECOMPANY_TYPE)->get();

            return view('insuranceCompanys.index', [
                'countries' => $countries,
                'cities' => $cities,
                'BANKS' => $BANKS,
                'types' => $type_id,

            ]);
        }
        if ($request->isMethod('POST')) {
            $insuranceCompanys = InsuranceCompany::with('bank_names', 'type')->withCount('clients')->withCount('branches')->withCount('teams');

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if (array_key_exists('type_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type_id']);
                    if (count($results) > 0)
                        $insuranceCompanys->whereIn('type_id', $results);
                }

                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $insuranceCompanys->where('active', $status);
                }


                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $insuranceCompanys->whereBetween('created_at', [$date[0], $date[1]]);
                }


                if ($search_params['has_teams'] != null) {
                    $status = $search_params['has_teams'] == "YES" ? '>' : '=';
                    $insuranceCompanys->where('teams_count', $status, 0);
                }
                if ($search_params['has_branches'] != null) {
                    $status = $search_params['has_branches'] == "YES" ? '>' : '=';
                    $insuranceCompanys->where('branches_count', $status, 0);
                }
                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $insuranceCompanys->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                        $q->orwhere('registration_no', 'like', "%" . $value . "%");
                    });
                }


            }

            //return $insuranceCompanys->get();
            return DataTables::eloquent($insuranceCompanys)
                ->editColumn('created_at', function ($insuranceCompany) {
                    return [
                        'display' => e(
                            $insuranceCompany->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $insuranceCompany->created_at->timestamp
                    ];
                })
                ->editColumn('name', function ($insuranceCompany) {
                    return '<a href="' . route('insuranceCompanys.edit', ['insuranceCompany' => $insuranceCompany->id]) . '" targer="_blank" class="">
                         ' . $insuranceCompany->name . '
                    </a>';
                })
                ->editColumn('telephone', function ($insuranceCompany) {
                    return '<a href="' . route('insuranceCompanys.view_calls', ['insuranceCompany' => $insuranceCompany->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $insuranceCompany->telephone .
                        '</a>';
                })
                ->editColumn('teams_count', function ($insuranceCompany) {
                    return '<a href="' . route('insuranceCompanys.view_teams', ['insuranceCompany' => $insuranceCompany->id]) . '?type=teams" class="viewCalls" title="show_teams">
                     ' . $insuranceCompany->teams_count . '
                    </a>';
                })
                ->editColumn('branches_count', function ($insuranceCompany) {
                    return '<a href="' . route('insuranceCompanys.view_brnaches', ['insuranceCompany' => $insuranceCompany->id]) . '?type=brnaches" class="viewCalls" title="branches">
                     ' . $insuranceCompany->branches_count . '
                    </a>';
                })
                ->editColumn('clients_count', function ($insuranceCompany) {
                    return '<a href="' . route('insuranceCompanys.view_clients', ['insuranceCompany' => $insuranceCompany->id]) . '?type=clients" class="viewCalls" title="clients">
                     ' . $insuranceCompany->clients_count . '
                    </a>';
                })

                ->editColumn('attachments_count', function ($insuranceCompany) {
                    return '<a href="' . route('insuranceCompanys.view_attachments', ['insuranceCompany' => $insuranceCompany->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $insuranceCompany->attachments_count . '
                    </a>';
                })
                ->editColumn('active', function ($insuranceCompany) {
                    return $insuranceCompany->active ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->addColumn('action', function ($insuranceCompany) {
                    $editBtn = $removeBtn = $menu = '';

                    if (Auth::user()->can('insuranceCompany_edit')) {
                        if (Auth::user()->canAny(['insuranceCompany_edit'])) {
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

                            if (Auth::user()->can('insuranceCompany_edit')) {

                                $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('insuranceCompanys.view_attachments', ['insuranceCompany' => $insuranceCompany->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                            Show Attachments (' . $insuranceCompany->attachments_count . ')
                                        </a>
                                    </div>';
                            }


                            $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                        }


                        $editBtn = '<a href="' . route('insuranceCompanys.edit', ['insuranceCompany' => $insuranceCompany->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateinsuranceCompany">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                        $removeBtn = '<a data-insuranceCompany-name="' . $insuranceCompany->name . '" href=' . route('insuranceCompanys.delete', ['insuranceCompany' => $insuranceCompany->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteinsuranceCompany"
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
                    return $editBtn . $removeBtn . $menu;
                })
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {


        $type_id = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::INSURANCECOMPANY_TYPE)->get();
        $BANKS = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::BANK)->get();

        $titles = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::titles)->get();
        $createView = view('insuranceCompanys.addedit', [
            'BANKS' => $BANKS,
            'titles' => $titles,
            'types' => $type_id,
        ])->render();
        return $createView;
    }


    public function InsuranceCompany(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',
            /*    'type_id' => 'required',
                'pos_type' => 'required',*/
        ]);
        if (isset($Id)) {
            $newInsuranceCompany = InsuranceCompany::find($Id);
            $newInsuranceCompany->update($request->all());


        }
        else
        {
            $newInsuranceCompany = InsuranceCompany::create($request->all());


        }

        $newInsuranceCompany->active = $request->active_c == 'on' ? 1 : 0;
        $newInsuranceCompany->save();

        $message = 'InsuranceCompany has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'InsuranceCompany has been added successfully!']);
        else
            return redirect()->route('insuranceCompanys.index', [
                'Id' => $newInsuranceCompany->id,
                'insuranceCompany' => $newInsuranceCompany->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, InsuranceCompany $insuranceCompany)
    {

        $type_id = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::INSURANCECOMPANY_TYPE)->get();
        $BANKS = Constant::where('module', Modules::RESTAURANT)->where('field', DropDownFields::BANK)->get();

        $titles = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::titles)->get();
        $createView = view('insuranceCompanys.addedit', [
                'BANKS' => $BANKS,
                'insuranceCompany' => $insuranceCompany,
                'titles' => $titles,
                'types' => $type_id]
        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, InsuranceCompany $InsuranceCompany)
    {
        $InsuranceCompany->delete();
        return response()->json(['status' => true, 'message' => 'InsuranceCompany Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*$r= new InsuranceCompanysExport($request->all());
        return $r->view();*/
        return Excel::download(new InsuranceCompanysExport($request->all()), 'insuranceCompanys.xlsx');
    }


    public function viewCalls(Request $request, InsuranceCompany $insuranceCompany)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($insuranceCompany->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($insuranceCompany->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($insuranceCompany->telephone, -9) . '%')->get();
        $callsView = view('insuranceCompanys.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'insuranceCompany' => $insuranceCompany,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }


    public function viewBrnaches(Request $request, InsuranceCompany $insuranceCompany)
    {

        $callsView = view('insuranceCompanys.branchs.indexP'
            , [
                'insuranceCompany' => $insuranceCompany,
            ])->render();
        return response()->json(['createView' => $callsView]);
    }


    public function viewAttachments(Request $request, InsuranceCompany $insuranceCompany)
    {

        $callsView = view('insuranceCompanys.attachments.indexP'
            , [
                'insuranceCompany' => $insuranceCompany,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewTeams(Request $request, InsuranceCompany $insuranceCompany)
    {
        $titles = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::titles)->get();

        $callsView = view('insuranceCompanys.teams.indexP'
            , [
                'titles' => $titles,

                'insuranceCompany' => $insuranceCompany,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewClients(Request $request, InsuranceCompany $insuranceCompany)
    {
        $titles = Constant::where('module', Modules::INSURANCECOMPANY)->where('field', DropDownFields::titles)->get();

        $callsView = view('insuranceCompanys.clients.indexP'
            , [
                'titles' => $titles,

                'insuranceCompany' => $insuranceCompany,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

}
