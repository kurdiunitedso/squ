<?php

namespace App\Http\Controllers\Leads;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\FacilityCallAction;
use App\Models\Facility;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Lead;

use App\Models\SystemSmsNotification;
use App\Models\VisitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {


            $status = Constant::where('module', Modules::LEAD)->where('field', DropDownFields::status)->get();
            $type_id = Constant::where('module', Modules::LEAD)->where('field', DropDownFields::LEAD_TYPE)->get();
            $facilities = Facility::all();


            return view('leads.index', [
                'facilities' => $facilities,
                'status' => $status,
                'types' => $type_id,

            ]);
        }
        if ($request->isMethod('POST')) {
            $leads = Lead::with('visit', 'facility', 'status', 'type')->withCount('attachments');

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if (array_key_exists('facility_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['facility_id']);
                    if (count($results) > 0)
                        $leads->whereIn('facility_id', $results);
                }
                if (array_key_exists('type_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type_id']);
                    if (count($results) > 0)
                        $leads->whereIn('type_id', $results);
                }

                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $leads->where('active', $status);
                }


                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $leads->whereBetween('created_at', [$date[0], $date[1]]);
                }
                if ($search_params['payment_date'] != null) {
                    $date = explode('to', $search_params['payment_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $leads->whereBetween('payment_date', [$date[0], $date[1]]);
                }


                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $leads->where(function ($q) use ($value) {
                        $q->where('contact_person', 'like', "%" . $value . "%");
                        $q->orwhere('contact_social', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                    });
                }
            }

            //return $leads->get();
            return DataTables::eloquent($leads)
                ->editColumn('title', function ($lead) {
                    return '<a href="' . route('leads.edit', ['lead' => $lead->id]) . '" targer="_blank" class="">
                         ' . $lead->title . '
                    </a>';
                })
                ->editColumn('facility.telephone', function ($lead) {
                    if ($lead->facility)
                        return '<a href="' . route('leads.view_calls', ['lead' => $lead->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                            . $lead->facility->telephone .
                            '</a>';
                })
                ->editColumn('visit.id', function ($lead) {
                    $visit = $lead->visit;
                    if ($visit)
                        return '<a href="' . route('visits.edit', ['visit' => $visit->id]) . '?updateAnswer=1" size="modal-xl" class="btnUpdatevisit" >' . $visit->id . ' </a>';
                    else
                        return 'NA';
                })
                ->editColumn('attachments_count', function ($lead) {
                    return '<a href="' . route('leads.view_attachments', ['lead' => $lead->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $lead->attachments_count . '
                    </a>';
                })
                ->editColumn('wheels', function ($lead) {
                    return $lead->wheels ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('intersted', function ($lead) {
                    return $lead->intersted ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->addColumn('action', function ($lead) {
                    $editBtn = $removeBtn = $menu = '';

                    if (Auth::user()->can('lead_edit')) {
                        if (Auth::user()->canAny(['lead_edit'])) {
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

                            if (Auth::user()->can('lead_edit')) {

                                $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('leads.view_attachments', ['lead' => $lead->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                            Show Attachments (' . $lead->attachments_count . ')
                                        </a>
                                    </div>';
                            }


                            $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                        }


                        $editBtn = '<a href="' . route('leads.edit', ['lead' => $lead->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatelead">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';


                        $createClient = '<a href="' . route('clientTrillions.create') . '?lead=' . $lead->id . '" target="_blank" class="btn btn-icon btn-active-light-primary w-30px h-30px ">
                    <span class="svg-icon svg-icon-3">
                   <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Food/Carrot.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <title>Create Client</title>
                    <desc>Create Client</desc>
                    <defs/>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M14.3724866,0.190822526 C11.3151949,5.41320416 11.3151949,9.23673357 14.3724866,11.6614108 C17.3047782,9.23673357 17.3047782,5.41320416 14.3724866,0.190822526 Z" fill="#999" opacity="0.3" transform="translate(14.325612, 5.926117) scale(-1, 1) rotate(-195.000000) translate(-14.325612, -5.926117) "/>
                        <path d="M17.5544671,3.37280304 C14.4971754,8.59518468 14.4971754,12.4187141 17.5544671,14.8433913 C20.4867588,12.4187141 20.4867588,8.59518468 17.5544671,3.37280304 Z" fill="#999" opacity="0.3" transform="translate(17.507592, 9.108097) rotate(-645.000000) translate(-17.507592, -9.108097) "/>
                        <path d="M15.9634768,1.78181278 C12.9061852,7.00419442 12.9061852,10.8277238 15.9634768,13.252401 C18.8957685,10.8277238 18.8957685,7.00419442 15.9634768,1.78181278 Z" fill="#999" opacity="0.3" transform="translate(15.916602, 7.517107) rotate(-315.000000) translate(-15.916602, -7.517107) "/>
                        <path d="M2.57844233,17.5134712 L2.86827202,17.8033009 C3.25879631,18.1938252 3.89196129,18.1938252 4.28248558,17.8033009 C4.67300987,17.4127766 4.67300987,16.7796116 4.28248558,16.3890873 L3.59132296,15.6979247 L4.60420359,13.8823782 L5.69669914,14.9748737 C6.08722343,15.365398 6.72038841,15.365398 7.1109127,14.9748737 C7.501437,14.5843494 7.501437,13.9511845 7.1109127,13.5606602 L5.69669914,12.1464466 C5.6702016,12.1199491 5.64258699,12.0952494 5.6140069,12.0723477 L6.62996485,10.2512852 L8.52512627,12.1464466 C8.91565056,12.5369709 9.54881554,12.5369709 9.93933983,12.1464466 C10.3298641,11.7559223 10.3298641,11.1227573 9.93933983,10.732233 L7.81801948,8.6109127 C7.75963657,8.55252979 7.69583066,8.50287505 7.62822323,8.46194849 L7.87276434,8.02361869 C8.41091279,7.05900994 9.62913819,6.71329556 10.5937469,7.251444 C10.7549891,7.34139987 10.9029979,7.45325048 11.0335565,7.58380908 L15.9162516,12.4665041 C16.6973001,13.2475527 16.6973001,14.5138826 15.9162516,15.2949312 C15.785693,15.4254898 15.6376841,15.5373404 15.476442,15.6272963 L3.46875087,22.3263028 C2.81004861,22.6937881 1.98744333,22.5793264 1.45408877,22.0459719 C0.920734216,21.5126173 0.806272498,20.690012 1.17375786,20.0313098 L2.57844233,17.5134712 Z" fill="#999"/>
                    </g>
                </svg>
                                    </span>
                                    </a>';

                        $createOffer = '<a href="' . route('offers.create') . '?telephone=' . $lead->mobile . '&lead=' . $lead->name . '&lead_id=' . $lead->id . '" target="_blank" class="btn btn-icon btn-active-light-primary w-30px h-30px ">
                                    <span class="svg-icon svg-icon-3">
                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Compiled-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <title>ِAdd Offer</title>
                    <defs/>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#999" fill-rule="nonzero" opacity="0.3"/>
                        <rect fill="#999" opacity="0.3" transform="translate(8.984240, 12.127098) rotate(-45.000000) translate(-8.984240, -12.127098) " x="7.41281179" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                        <rect fill="#999" opacity="0.3" transform="translate(15.269955, 12.127098) rotate(-45.000000) translate(-15.269955, -12.127098) " x="13.6985261" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                        <rect fill="#999" transform="translate(12.127098, 15.269955) rotate(-45.000000) translate(-12.127098, -15.269955) " x="10.5556689" y="13.6985261" width="3.14285714" height="3.14285714" rx="0.75"/>
                        <rect fill="#999" transform="translate(12.127098, 8.984240) rotate(-45.000000) translate(-12.127098, -8.984240) " x="10.5556689" y="7.41281179" width="3.14285714" height="3.14285714" rx="0.75"/>
                    </g>
                </svg>
                                    </span>
                                    </a>';


                        $removeBtn = '<a data-lead-name="' . $lead->name . '" href=' . route('leads.delete', ['lead' => $lead->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletelead"
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
                    return $editBtn . $removeBtn . $createClient . $createOffer . $menu;
                })
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $data['account_manager_list'] = Employee::where(['active' => true])->get();
        $data['countries'] = Country::all();
        $data['facility'] = Facility::find($request->facility_id);
        $data['status'] = Constant::where('module', Modules::LEAD)->where('field', DropDownFields::status)->get();
        $data['facilities'] = Facility::all();
        $data['company_types'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::facility_type)->get();
        $data['Types'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)
            ->get();
        $data['pos_type'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
        $data['OSTYPES'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::OS_TYPE)->get();
        $data['type_id'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
        $data['BANKS'] = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $data['PAYMENTTYPES'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $data['preparation_time'] = DropDownFields::PREPARATION_TIME;
        $data['printer_type'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
        $data['sys_satisfaction_rate'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $data['cities'] = City::all();
        $data['category_id'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
        $data['titles'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();

        $data['visit'] = VisitRequest::find($request->visit_request_id);
        if ($request->ajax()) {
            $createView = view('leads.formP', $data)->render();
            return response()->json(['createView' => $createView]);
        }
        $createView = view('leads.addedit', $data)->render();


        return $createView;
    }


    public function Lead(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'owner_name' => 'required',
            /*    'type_id' => 'required',
                'pos_type' => 'required',*/
        ]);
        $data = $request->all();
        $data['wheels'] = $request->has('wheels');
        $data['active'] = $request->has('active');
        $data['has_agency'] = $request->has('has_agency');
        $data['intersted'] = $request->has('intersted');
        // dd($data);
        if (isset($Id)) {
            $newLead = Lead::find($Id);
            $newLead->update($data);
        } else {
            $facility = 0;
            if ($request->facility_id == null) {
                $facility = Facility::where('telephone', $request->mobile)->get()->first();
            }
            if ($facility) {
                $data['facility_id'] = $facility->id;
            }
            $newLead = Lead::create($data);
        }

        // $newLead->wheels = $request->wheel_c == 'on' ? 1 : 0;
        // $newLead->active = $request->active_c == 'on' ? 1 : 0;
        // $newLead->save();

        $message = 'Lead has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Lead has been added successfully!']);
        else
            return redirect()->route('leads.edit', [
                'Id' => $newLead->id,
                'lead' => $newLead->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Lead $lead)
    {
        $data['account_manager_list'] = Employee::where(['active' => true])->get();
        $data['lead'] = $lead;
        $data['countries'] = Country::all();
        $data['status'] = Constant::where('module', Modules::LEAD)->where('field', DropDownFields::status)->get();
        $data['facilities'] = Facility::all();
        $data['company_types'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::facility_type)->get();
        $data['TYPES'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)
            ->get();
        $data['posTypes'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
        $data['OSTYPES'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::OS_TYPE)->get();
        $data['type_id'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
        $data['BANKS'] = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $data['PAYMENTTYPES'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $data['preparation_time'] = DropDownFields::PREPARATION_TIME;
        $data['printer_type'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
        $data['sys_satisfaction_rate'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $data['cities'] = City::all();
        $data['titles'] = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();
        $data['facility'] = $lead->facility;
        $data['audits'] = $lead->audits()->with('user')->orderByDesc('created_at')->get();
        $data['CATEGORYS'] =  Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
        $data['attachmentAudits'] = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($lead) {
            $query->where('attachable_type', lead::class)
                ->where('attachable_id', $lead->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $createView = view(
            'leads.addedit',
            $data
        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Lead $Lead)
    {
        $Lead->delete();
        return response()->json(['status' => true, 'message' => 'Lead Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*$r= new LeadsExport($request->all());
        return $r->view();*/
        return Excel::download(new LeadsExport($request->all()), 'leads.xlsx');
    }


    public function viewCalls(Request $request, Lead $lead)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($lead->facility->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($lead->facility->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($lead->facility->telephone, -9) . '%')->get();
        $callsView = view(
            'leads.viewCalls',
            [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'lead' => $lead,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }


    public function viewAttachments(Request $request, Lead $lead)
    {

        $callsView = view(
            'leads.attachments.indexP',
            [
                'lead' => $lead,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
