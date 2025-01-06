<?php

namespace App\Http\Controllers\ClientTrillions;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\CaptinsExport;
use App\Exports\ClientTrillionsExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ClientTrillion;
use App\Models\CdrLog;
use App\Models\City;

use App\Models\Constant;

use App\Models\Country;
use App\Models\Facility;
use App\Models\Lead;
use App\Models\SystemSmsNotification;
use App\Services\Dashboard\Filters\ClientTrillionFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class ClientTrillionController extends Controller
{
    protected $filterService;

    public function __construct(ClientTrillionFilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $cities = City::all();
            $countries = Country::all();
            $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
            $attachmentConstants = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::ATTACHMENT_TYPE)->get();

            return view('clientTrillions.index', [
                'cities' => $cities,
                'countries' => $countries,
                'company_types' => $company_types,
                'attachmentConstants' => $attachmentConstants,

            ]);
        }
        if ($request->isMethod('POST')) {
            $clientTrillions = ClientTrillion
                ::with('city', 'type', 'country')
                ->withCount('teams')
                ->withCount('claims')
                ->withCount('attachments')
                ->withCount('socials');


            if ($request->input('params')) {
                $this->filterService->applyFilters($clientTrillions, $request->input('params'));
            }

            //return $clientTrillions->get();
            return DataTables::eloquent($clientTrillions)
                ->editColumn('created_at', function ($clientTrillion) {
                    if ($clientTrillion->created_at)
                        return [
                            'display' => e(
                                $clientTrillion->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $clientTrillion->created_at->timestamp
                        ];
                })
                ->editColumn('registration_name', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.edit', ['clientTrillion' => $clientTrillion->id]) . '" targer="_blank" class="">
                         ' . $clientTrillion->registration_name . '
                    </a>';
                })
                ->editColumn('clientTrillion_id', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.edit', ['clientTrillion' => $clientTrillion->id]) . '" targer="_blank" class="">
                         ' . $clientTrillion->clientTrillion_id . '
                    </a>';
                })
                ->editColumn('teams_count', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.view_teams', ['clientTrillion' => $clientTrillion->id]) . '?type=teams" class="viewTeams" title="show_teams">
                     ' . $clientTrillion->teams_count . '
                    </a>';
                })
                ->editColumn('socials_count', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.view_socials', ['clientTrillion' => $clientTrillion->id]) . '?type=socials" class="viewSocials" title="show_socials">
                     ' . $clientTrillion->socials_count . '
                    </a>';
                })
                ->editColumn('attachments_count', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.view_attachments', ['clientTrillion' => $clientTrillion->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $clientTrillion->attachments_count . '
                    </a>';
                })
                ->editColumn('claims_count', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.view_claims', ['clientTrillion' => $clientTrillion->id]) . '?type=claims" title="claims"  class="menu-link px-3 viewClaims" >
                     ' . $clientTrillion->claims_count . '
                    </a>';
                })
                ->editColumn('telephone', function ($clientTrillion) {
                    return '<a href="' . route('clientTrillions.view_calls', ['clientTrillion' => $clientTrillion->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $clientTrillion->telephone .
                        '</a>';
                })
                ->editColumn('active', function ($clientTrillion) {
                    return $clientTrillion->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->addColumn('action', function ($clientTrillion) {
                    return $clientTrillion->action_buttons;
                })
                ->escapeColumns([])
                // ->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'telephone', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $cities = City::all();
        $shifts = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::shifts)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::payment_type_captin)->get();
        $PAYMENT_METHODS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::payment_method_captin)->get();
        $countries = Country::all();
        $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
        $attachmentConstants = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::ATTACHMENT_TYPE)->get();
        $facility = Facility::find($request->facility);
        $lead = Lead::find($request->lead);
        if (!$facility)
            if ($lead)
                $facility = $lead->facility ? $lead->facility : null;


        // $motor_cc=DropDownFields::MOTOR_CC;
        $createView = view('clientTrillions.addedit', [
            'cities' => $cities,
            'shifts' => $shifts,
            'facility' => $facility,
            'lead' => $lead,
            'BANKS' => $BANKS,
            'PAYMENT_METHODS' => $PAYMENT_METHODS,
            'PAYMENT_TYPES' => $PAYMENTTYPES,
            'countries' => $countries,
            'company_types' => $company_types,
            'attachmentConstants' => $attachmentConstants,
        ])->render();
        return $createView;
    }


    public function ClientTrillion(Request $request, $Id = null)
    {
        //return $request->all();
        $save = 0;
        $request->validate([
            'name' => 'required',

        ]);
        if (isset($Id)) {
            $save = 1;
            $newClientTrillion = ClientTrillion::find($Id);
            $newClientTrillion->update($request->all());
        } else
            $newClientTrillion = ClientTrillion::create($request->all());
        $newClientTrillion->active = $request->active_c == 'on' ? 1 : 0;
        $newClientTrillion->save();


        $message = 'Client Trillion has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Client Trillion has been added successfully!']);
        else
            if ($save == 1)
            return redirect()->route('clientTrillions.edit', ['clientTrillion' => $newClientTrillion->id])
                ->with('status', $message);
        else
            return redirect()->route('clientTrillions.index', [
                'Id' => $newClientTrillion->id,
                //'clientTrillion' => $newClientTrillion->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, ClientTrillion $clientTrillion)
    {

        $cities = City::all();
        $shifts = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::CAPTIN_SHIFT)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::payment_type_captin)->get();
        $PAYMENT_METHODS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::payment_method_captin)->get();
        $countries = Country::all();
        $company_types = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::client_type)->get();
        $attachmentConstants = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::ATTACHMENT_TYPE)->get();
        $audits = $clientTrillion->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($clientTrillion) {
            $query->where('attachable_type', ClientTrillion::class)
                ->where('attachable_id', $clientTrillion->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();


        $createView = view(
            'clientTrillions.addedit',
            [
                'cities' => $cities,
                'clientTrillion' => $clientTrillion,
                'shifts' => $shifts,
                'BANKS' => $BANKS,
                'PAYMENT_METHODS' => $PAYMENT_METHODS,
                'PAYMENT_TYPES' => $PAYMENTTYPES,
                'countries' => $countries,
                'company_types' => $company_types,
                'attachmentConstants' => $attachmentConstants,
                'audits' => $audits,
                'attachmentAudits' => $attachmentAudits,

            ]


        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, ClientTrillion $clientTrillion)
    {
        $clientTrillion->delete();
        return response()->json(['status' => true, 'message' => 'ClientTrillion Deleted Successfully !']);
    }


    public function viewCalls(Request $request, ClientTrillion $clientTrillion)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($clientTrillion->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($clientTrillion->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($clientTrillion->telephone, -9) . '%')->get();
        $callsView = view(
            'clientTrillions.viewCalls',
            [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'clientTrillion' => $clientTrillion,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function export(Request $request)
    {
        /*$c=new ClientTrillionsExport($request->all());
        return $c->view();*/
        return Excel::download(new ClientTrillionsExport($request->all()), 'ClientTrillions.xlsx');
    }

    public function viewAttachments(Request $request, ClientTrillion $clientTrillion)
    {

        $callsView = view(
            'clientTrillions.viewAttachments',
            [
                'clientTrillion' => $clientTrillion,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewClaims(Request $request, ClientTrillion $clientTrillion)
    {

        $callsView = view(
            'clientTrillions.claims.indexP',
            [
                'clientTrillion' => $clientTrillion,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }


    public function viewTeams(Request $request, ClientTrillion $clientTrillion)
    {
        $titles = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::titles)->get();

        $callsView = view(
            'clientTrillions.teams.indexP',
            [
                'titles' => $titles,

                'clientTrillion' => $clientTrillion,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewSocials(Request $request, ClientTrillion $clientTrillion)
    {
        $titles = Constant::where('module', Modules::CLIENTTRILLION)->where('field', DropDownFields::titles)->get();

        $callsView = view(
            'clientTrillions.socials.indexP',
            [
                'titles' => $titles,

                'clientTrillion' => $clientTrillion,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
