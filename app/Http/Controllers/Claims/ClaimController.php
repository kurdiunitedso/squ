<?php

namespace App\Http\Controllers\Claims;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\ClaimsExport;
use App\helper\CustomPDFApp;
use App\helper\CustomPDFAppClaim;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientCallAction;
use App\Models\ClientTrillion;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Claim;


use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class ClaimController extends Controller
{

    public function index(Request $request)
    {

        if ($request->isMethod('GET')) {


            $status = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::status)->get();

            $type_id = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::CLAIM_TYPE)->get();
            $clients = ClientTrillion::all();


            return view('claims.index', [
                'clients' => $clients,
                'status' => $status,
                'types' => $type_id,

            ]);
        }
        if ($request->isMethod('POST')) {
            $processing = \App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->Where('field', \App\Enums\DropDownFields::status)->where('name', 'processing')->get()->first();
            $processing = isset($processing) ? $processing->id : 0;
            $paid = \App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->Where('field', \App\Enums\DropDownFields::status)->where('name', 'completed')->get()->first();
            $paid = isset($paid) ? $paid->id : 0;

            $claims = Claim::with('items', 'client', 'status', 'type', 'currencys')->withCount('attachments')->withCount('items');
            $c1 = Claim::select('*');
            $c2 = Claim::select('*');
            $c3 = Claim::select('*');
            $c4 = Claim::select('*');

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if (array_key_exists('type_id', $search_params)) {
                    $results = $search_params['type_id'];
                    $results = implode(',', $results);
                    $claims->where('types', 'like', '%' . $results . '%');
                }
                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0) {
                        $claims->whereIn('status_id', $results);
                    }
                }
                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $claims->where('active', $status);
                }
                if ($search_params['is_submit'] != null) {
                    $status = $search_params['is_submit'] == "YES" ? 1 : 0;
                    $claims->where('submit', $status);
                }
                if ($search_params['is_paid'] != null) {
                    $status = $search_params['is_paid'] == "YES" ? 1 : 0;
                    $claims->where('paid', $status);
                }


                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $claims->whereBetween('created_at', [$date[0], $date[1]]);
                }
                if ($search_params['payment_date'] != null) {
                    $date = explode('to', $search_params['payment_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $claims->whereBetween('payment_date', [$date[0], $date[1]]);
                }


                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $claims->where(function ($q) use ($value) {
                        $q->whereHas('client', function ($t) use ($value) {
                            $t->where('name', 'like', "%" . $value . "%");
                            $t->orWhere('name_en', 'like', "%" . $value . "%");
                        });
                    });
                }
            }

            $total_amount = $c1->sum('cost');
            $paid_amount = $c2->where('status_id', $paid)->sum('cost');
            $not_paid_amount = $c3->where('status_id', $processing)->where('submit', 1)->sum('cost');
            $not_sent_notpaid_amount = $c4->where('status_id', $processing)->where('submit', 0)->sum('cost');

            //return $claims->get();
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
                    return $claim->cost . " " . (Constant::find($claim->currency) ? Constant::find($claim->currency)->name : '');
                })
                ->editColumn('items_count', function ($claim) {
                    return '<a href="' . route('claims.view_items', ['claim' => $claim->id]) . '?type=teams"  data_id="' . $claim->id . '"  class="viewItem" title="show_items">
                     ' . $claim->items_count . '
                    </a>';
                })
                ->editColumn('attachments_count', function ($claim) {
                    return '<a href="' . route('claims.view_attachments', ['claim' => $claim->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $claim->attachments_count . '
                    </a>';
                })
                ->editColumn('active', function ($claim) {
                    return $claim->active ? '<h4 class="text text-success bold">Yes</h4>' : '<h4 class="text text-danger bold">No</h4>';
                })
                ->addColumn('action', function ($claim) {
                    $editBtn = $removeBtn = $printClaim = $sendEmail = $menu = '';
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
                ->with('not_sent_notpaid_amount', $not_sent_notpaid_amount)
                ->with('not_paid_amount', $not_paid_amount)
                ->with('paid_amount', $paid_amount)
                ->with('total_amount', $total_amount)
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $countries = Country::all();
        $cities = City::all();
        $client = ClientTrillion::find($request->clientTrillion);
        $Types = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)
            ->get();
        $status = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::status)->get();
        $currency = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::currency)->get();
        $payment_method = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $type_id = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::CLAIM_TYPE)->get();
        $clients = ClientTrillion::all();
        $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();

        $createView = view('claims.addedit', [
            'clients' => $clients,
            'client' => $client,
            'status' => $status,
            'payment_method' => $payment_method,
            'currencies' => $currency,
            'TYPES' => $Types,
            'types' => $type_id,
            'countries' => $countries,
            'projects' => [],
            'company_types' => $company_types,
            'cities' => $cities,
        ])->render();
        return $createView;
    }

    public function printClaim(Request $request, Claim $claim)
    {
        $title = $claim->id;
        $path2 = public_path('cp'); // upload directory
        $data['font'] = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/JannaBold.ttf', 'TrueTypeUnicode', '', '32');
        $fontname = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/Janna.ttf', 'TrueTypeUnicode', '', '32');
        $pdf = new CustomPDFAppClaim();
        $pdf->SetFont($fontname, '', 10, '', false);
        $pdf->reportTitle = $title;
        $pdf->reportNo = $claim->id;
        $pdf->reportDate = ' Date: ' . date('d/m/Y');
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(20);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        /*  $pdf->setRTL(true);*/
        $pdf->AddPage();

        $data['claim'] = $claim;


        $htmlcontent2 = view('claims.printClaim', $data)->render();


        $pdf->WriteHTML($htmlcontent2);
        $path = public_path('uploads'); // upload directory
        return $pdf->Output($path . DIRECTORY_SEPARATOR . "claims/" . $title, 'I');
    }

    public function sendEmail(Request $request, Claim $claim)
    {

        $callsView = view(
            'claims.sendEmail',
            [

                'claim' => $claim,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function sendEmailTo(Request $request)
    {

        $claim = Claim::find($request->claim_id);
        $client = ClientTrillion::find($claim->client_id);

        // Format the email subject with client name and current date
        $emailSubject = $client->name_locale . ' Price Offer -' . date('d/m/Y') . '-';
        // dd($emailSubject);
        $path2 = public_path('cp'); // upload directory

        // Prepare email data
        $data = [
            'font' => \TCPDF_FONTS::addTTFfont($path2 . '/fonts/JannaBold.ttf', 'TrueTypeUnicode', '', '32'),
            'claim' => $claim,
            'text' => $request->text,
            'clientName' => $client->name_locale  // Add client name to data array for email template
        ];





        $title = $claim->title;
        $data['font'] = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/JannaBold.ttf', 'TrueTypeUnicode', '', '32');
        $fontname = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/Janna.ttf', 'TrueTypeUnicode', '', '32');
        $pdf = new CustomPDFAppClaim();
        $pdf->SetFont($fontname, '', 10, '', false);
        $pdf->reportTitle = $title;
        $pdf->reportNo = $claim->id;
        $pdf->reportDate = ' Date: ' . date('d/m/Y');
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(20);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        /*  $pdf->setRTL(true);*/
        $pdf->AddPage();
        $title = $claim->id;
        $data['claim'] = $claim;
        $data['text'] = $request->text;


        $htmlcontent2 = view('claims.printClaim', $data)->render();


        $pdf->WriteHTML($htmlcontent2);
        $title = $title . \Illuminate\Support\Str::random(10) . ".pdf";
        $path = public_path('uploads'); // upload directory
        $pdf->Output($path . DIRECTORY_SEPARATOR . "claims/" . $title, 'F');

        Storage::disk('local')->put("clientTrillions/attachments/" . $title, file_get_contents($path . DIRECTORY_SEPARATOR . "claims/" . $title));
        Storage::disk('local')->put("claims/attachments/" . $title, file_get_contents($path . DIRECTORY_SEPARATOR . "claims/" . $title));

        $attachment = new Attachment([
            'attachment_type_id' => 396,
            'file_hash' => $title,
            'source' => 'claim',
            'file_name' => $title,
        ]);
        $attachment2 = new Attachment([
            'attachment_type_id' => 396,
            'file_hash' => $title,
            'source' => 'client',
            'file_name' => $title,
        ]);
        $claim->attachments()->save($attachment);
        $client->attachments()->save($attachment2);


        // Update the Mail::send section
        Mail::send('claims.sendEmailText', $data, function ($message) use ($path, $claim, $pdf, $title, $request, $emailSubject, $client) {
            $message->from('trillionz@developon.co');
            $tos = $this->filterArrayForEmailValues(explode(';', $request->to));
            foreach ($tos as $k => $v) {
                $message->to($v);
            }

            if ($request->cc) {
                $ccs = $this->filterArrayForEmailValues(explode(';', $request->cc));
                foreach ($ccs as $k => $v) {
                    $message->cc($v);
                }
            }

            $message->subject($emailSubject);
            $message->attach($path . DIRECTORY_SEPARATOR . "/claims/" . $title);
        });


        $claim->submit = 1;
        $claim->save();

        return response()->json(['status' => true, 'message' => 'Claim Sent Successfully !']);
    }

    public function Claim(Request $request, $Id = null)
    {
        //return $request->all();
        $processing = Constant::where('module', Modules::CLAIM)->Where('field', DropDownFields::status)->where('name', 'processing')->get()->first();
        $processing = isset($processing) ? $processing->id : 0;
        $new = 0;
        if (!$request->ajax()) {
            $request->validate([
                'name' => 'required',

                /*    'type_id' => 'required',
                    'pos_type' => 'required',*/
            ]);
        }
        if (isset($Id)) {
            $newClaim = Claim::find($Id);
            $newClaim->update($request->all());
            if (!$request->ajax()) {
                $request->validate([
                    'name' => 'required',
                    'currency' => 'required',
                    /*    'type_id' => 'required',
                        'pos_type' => 'required',*/
                ]);
            }
        } else {

            $newClaim = Claim::create($request->all());
            $newClaim->status_id = $processing;
            $new = 1;
        }
        if ($newClaim->status_id == 0 || $newClaim->status_id == null)
            $newClaim->status_id = $processing;
        $newClaim->active = $request->active_c == 'on' ? 1 : 0;
        $newClaim->submit = $request->submit_c == 'on' ? 1 : 0;
        $newClaim->vat = $request->vat_c == 'on' ? 1 : 0;
        $newClaim->paid = $request->paid_c == 'on' ? 1 : 0;
        $newClaim->types = $request->typess ? implode(',', $request->typess) : $newClaim->types;
        $newClaim->save();
        $client = $newClaim->client;
        $client->update($request->all());

        $message = 'Claim has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Claim has been added successfully!']);
        else
            if ($new)
            return redirect()->route('claims.edit', [
                'Id' => $newClaim->id,
                'claim' => $newClaim->id
            ])
                ->with('status', $message);
        else
            return redirect()->route('claims.index', [
                'Id' => $newClaim->id,
                'claim' => $newClaim->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Claim $claim)
    {

        $status = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::status)->get();
        $currency = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::currency)->get();
        $type_id = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::CLAIM_TYPE)->get();
        $payment_method = Constant::where('module', Modules::CLAIM)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $Types = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)
            ->get();
        $clients = ClientTrillion::all();
        $projects = $claim->client->socials;
        $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
        $countries = Country::all();
        $cities = City::all();
        $client = $claim->client;
        $audits = $claim->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($claim) {
            $query->where('attachable_type', claim::class)
                ->where('attachable_id', $claim->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();


        if ($request->type == "pop") {
            $createView = view(
                'claims.formP',
                [

                    'claim' => $claim,
                    'clients' => $clients,
                    'status' => $status,
                    'currencies' => $currency,
                    'projects' => $projects,
                    'company_types' => $company_types,
                    'countries' => $countries,
                    'cities' => $cities,
                    'payment_method' => $payment_method,
                    'client' => $client,
                    'audits' => $audits,
                    'attachmentAudits' => $attachmentAudits,
                    'types' => $type_id
                ]
            )->render();
            return response()->json(['createView' => $createView]);
        }
        $createView = view(
            'claims.addedit',
            [

                'claim' => $claim,
                'clients' => $clients,
                'status' => $status,
                'currencies' => $currency,
                'projects' => $projects,
                'company_types' => $company_types,
                'countries' => $countries,
                'cities' => $cities,
                'payment_method' => $payment_method,
                'client' => $client,
                'audits' => $audits,
                'attachmentAudits' => $attachmentAudits,
                'types' => $type_id
            ]
        )->render();
        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Claim $Claim)
    {
        $Claim->delete();
        return response()->json(['status' => true, 'message' => 'Claim Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*$r= new ClaimsExport($request->all());
        return $r->view();*/
        return Excel::download(new ClaimsExport($request->all()), 'claims.xlsx');
    }


    public function viewCalls(Request $request, Claim $claim)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($claim->client->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($claim->client->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($claim->client->telephone, -9) . '%')->get();
        $callsView = view(
            'claims.viewCalls',
            [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'claim' => $claim,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }


    public function viewItems(Request $request, Claim $claim)
    {

        $callsView = view(
            'claims.items.indexP',
            [
                'claim' => $claim,
            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }


    public function viewAttachments(Request $request, Claim $claim)
    {

        $callsView = view(
            'claims.attachments.indexP',
            [
                'claim' => $claim,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
