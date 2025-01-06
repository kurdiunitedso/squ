<?php

namespace App\Http\Controllers\ClientTrillions;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\ClientTrillionsExport;
use App\Http\Controllers\Controller;
use App\Models\Captin;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use App\Models\ClientTrillion;

use App\Models\Claim;
use App\Models\InsuranceCompany;
use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ClientTrillionClaimController extends Controller
{


    public function indexClaim(Request $request, ClientTrillion $clientTrillion)
    {
        if ($request->isMethod('GET')) {


            return view('clientTrillions.claims.index', [
                'clientTrillion' => $clientTrillion,
            ]);
        }
        if ($request->isMethod('POST')) {
            $processing = \App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->Where('field', \App\Enums\DropDownFields::status)->where('name', 'processing')->get()->first();
            $processing = isset($processing) ? $processing->id : 0;
            $paid = \App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->Where('field', \App\Enums\DropDownFields::status)->where('name', 'paid')->get()->first();
            $paid = isset($paid) ? $paid->id : 0;

            $claims = Claim::with('items', 'client', 'status', 'type')->withCount('attachments')->withCount('items')
                ->where('client_id', $clientTrillion->id);
            $c1 = Claim::where('client_id', $clientTrillion->id);
            $c2 = Claim::where('client_id', $clientTrillion->id);
            $c3 = Claim::where('client_id', $clientTrillion->id);


            $total_amount = $c1->sum('cost');
            $paid_amount = $c2->where('status_id', $paid)->sum('cost');
            $not_paid_amount = $c3->where('status_id', $processing)->sum('cost');


            return DataTables::eloquent($claims)

                ->editColumn('client.name', function ($claim) {

                    if ($claim->client())
                        $name = $claim->client->name;
                    return '<a href="' . route('claims.edit', ['claim' => $claim->id]) . '" targer="_blank" class="">
                         ' . $name . '
                    </a>';
                })
                ->editColumn('title', function ($claim) {
                    $types = '';
                    foreach (explode(',', $claim->types) as $k => $v)
                        $types .= (Constant::find($v) ? Constant::find($v)->name : '') . ",";

                    $types = rtrim($types, ',');
                    return $types;
                })
                ->editColumn('client.telephone', function ($claim) {
                    if ($claim->client)
                        return '<a href="' . route('claims.view_calls', ['claim' => $claim->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                            . $claim->client->telephone .
                            '</a>';
                })
                ->editColumn('cost', function ($claim) {
                    return $claim->cost ." ".(Constant::find($claim->currency)?Constant::find($claim->currency)->name:'');

                })
             /*   ->editColumn('items_count', function ($claim) {
                    return '<a href="' . route('claims.view_items', ['claim' => $claim->id]) . '?type=teams"  data_id="' . $claim->id . '"  class="viewItem" title="show_items">
                     ' . $claim->items_count . '
                    </a>';
                })*/
                ->editColumn('attachments_count', function ($claim) {
                    return '<a href="' . route('claims.view_attachments', ['claim' => $claim->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $claim->attachments_count . '
                    </a>';
                })
                ->editColumn('active', function ($claim) {
                    return $claim->active ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->editColumn('active', function ($claim) {
                    return $claim->active ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->addColumn('action', function ($claim) {
                    $editBtn = $removeBtn = $menu = '';

                    if (Auth::user()->can('claim_edit')) {
                        if (Auth::user()->canAny(['claim_edit'])) {
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

                            if (Auth::user()->can('claim_edit')) {

                                $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('claims.view_attachments', ['claim' => $claim->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                                            Show Attachments (' . $claim->attachments_count . ')
                                        </a>
                                    </div>';

                                $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('claims.edit', ['claim' => $claim->id]) . '?type=pop" title="edit Claim"  class="menu-link px-3 AddclaimsModal" >
                                           Change Status
                                        </a>
                                    </div>';

                            }


                            $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                        }
                        $printClaim = '<a href="' . route('claims.printClaim', ['claim' => $claim->id]) . '?type=printClaim" target="_blank"  class="btn btn-icon btn-active-light-primary w-30px h-30px printClaim">
                    <span class="svg-icon svg-icon-3">
<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Devices/Printer.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Print</title>

    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M16,17 L16,21 C16,21.5522847 15.5522847,22 15,22 L9,22 C8.44771525,22 8,21.5522847 8,21 L8,17 L5,17 C3.8954305,17 3,16.1045695 3,15 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,15 C21,16.1045695 20.1045695,17 19,17 L16,17 Z M17.5,11 C18.3284271,11 19,10.3284271 19,9.5 C19,8.67157288 18.3284271,8 17.5,8 C16.6715729,8 16,8.67157288 16,9.5 C16,10.3284271 16.6715729,11 17.5,11 Z M10,14 L10,20 L14,20 L14,14 L10,14 Z" fill="#999"/>
        <rect fill="#999" opacity="0.3" x="8" y="2" width="8" height="2" rx="1"/>
    </g>
</svg>
                    </span>
                    </a>';
                        $sendEmail = '<a href="javascript:;"  link="' . route('claims.sendEmail', ['claim' => $claim->id]) . '?type=sendEmail"  class="btn btn-icon btn-active-light-primary w-30px h-30px sendEmail">
                    <span class="svg-icon svg-icon-3">
<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Outgoing-mail.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Mail</title>

    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M18.1444251,10.8396467 L12,14.1481833 L5.85557487,10.8396467 C5.4908718,10.6432681 5.03602525,10.7797221 4.83964668,11.1444251 C4.6432681,11.5091282 4.77972206,11.9639747 5.14442513,12.1603533 L11.6444251,15.6603533 C11.8664074,15.7798822 12.1335926,15.7798822 12.3555749,15.6603533 L18.8555749,12.1603533 C19.2202779,11.9639747 19.3567319,11.5091282 19.1603533,11.1444251 C18.9639747,10.7797221 18.5091282,10.6432681 18.1444251,10.8396467 Z" fill="#999"/>
        <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#999" fill-rule="nonzero" opacity="0.3" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
    </g>
</svg>
                    </span>
                    </a>';

                        $editBtn = '<a href="' . route('claims.edit', ['claim' => $claim->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateclaim">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                        $removeBtn = '<a data-claim-name="' . $claim->name . '" href=' . route('claims.delete', ['claim' => $claim->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteclaim"
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
                    return $editBtn . $sendEmail . $printClaim . $removeBtn . $menu;
                })
                ->with('not_paid_amount', $not_paid_amount)
                ->with('paid_amount', $paid_amount)
                ->with('total_amount', $total_amount)
                ->escapeColumns([])
                ->make();
        }
    }

    public function editClaim(Request $request, Claim $claim)
    {

        $cities = City::all();

        $clientTrillion = ClientTrillion::find($team->client_trillion_id);
        $countries = Country::all();
        $cities = City::all();
        $status = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::status)->get();
        $type_id = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::CLAIM_TYPE)->get();
        $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
        $projects=$clientTrillion->socials;
        $createView = view('clientTrillions.claims.addedit'
            , [
                'claim' => $claim,
                'projects' => $projects,
                'status' => $status,
                'types' => $type_id,
                'countries' => $countries,

                'company_types' => $company_types,
                'cities' => $cities,

            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function createClaim(Request $request)
    {

        $clientTrillion = ClientTrillion::find($request->clientTrillion);
        $countries = Country::all();
        $cities = City::all();
        $status = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::status)->get();
        $type_id = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::CLAIM_TYPE)->get();
        $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
        $projects=$clientTrillion->socials;
        $createView = view('clientTrillions.claims.addedit'
            , [
                'clientTrillion' => $clientTrillion,
                'cities' => $cities,
                'status' => $status,
                'types' => $type_id,
                'countries' => $countries,
                'projects' => $projects,
                'company_types' => $company_types,


            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function deleteClaim(Request $request, Claim $claim)
    {
        $claim->delete();
        return response()->json(['status' => true, 'message' => 'ClientTrillion Deleted Successfully !']);
    }

    public function storeClaim(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'client_trillion_id' => ['required'],
            'mobile' => 'required',

            // 'valid_from' => 'required',
        ]);
        $claim = 0;
        if ($request->claim_id)
            $claim = Claim::find($request->claim_id);
        if ($claim)
            $claim->update($request->all());
        else
            $claim = Claim::create($request->all());


        return response()->json(['status' => true, 'message' => 'Claim has been added successfully!']);
    }

    public function updateClaim(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'client_trillion_id' => ['required'],
            'mobile' => 'required',

            // 'valid_from' => 'required',
        ]);
        $claim = 0;
        if ($request->claim)
            $claim = Claim::find($request->claim);
        if ($claim)
            $claim->update($request->all());
        else
            $claim = Claim::create($request->all());


        return response()->json(['status' => true, 'message' => 'Claim has been updated successfully!']);
    }

    public function viewCalls(Request $request, Claim $claim)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($claim->mobile, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($claim->mobile, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($claim->mobile, -9) . '%')->get();
        $callsView = view('clientTrillions.claims.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'claim' => $claim,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }


}
