<?php

namespace App\Http\Controllers\InsuranceCompany;

use App\Enums\DropDownFields;
use App\Enums\Modules;

use App\Http\Controllers\Controller;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientCallAction;
use App\Models\Constant;
use App\Models\Country;
use App\Models\InsuranceCompany;


use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class InsuranceCompanyClientController extends Controller
{


    public function indexClient(Request $request, InsuranceCompany $insuranceCompany)
    {
        if ($request->isMethod('GET')) {


            return view('insuranceCompanys.clients.index', [
                'insuranceCompany' => $insuranceCompany,
            ]);
        }
        if ($request->isMethod('POST')) {
            $clients = Client::
            select('clients.*')->wherenotnull('insurance_company_id')->where('insurance_company_id',$insuranceCompany->id)
                ->with('city', 'categoryss', 'statuss')
                ->withCount('orders')
                ->withCount('attachments')
                ->withCount('callPhone')
                ->withCount('smsPhone');

            return DataTables::eloquent($clients)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orwhere('telephone', 'like', "%" . $value . "%");
                        $q->orwhere('client_id', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('created_at', function ($client) {
                    if ($client->created_at)
                        return [
                            'display' => e(
                                $client->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $client->created_at->timestamp
                        ];
                })
                ->editColumn('name', function ($client) {
                    return
                    '<a href="' . route('insuranceCompanys.clients.edit', ['client' => $client->id]) . '" class="btnUpdateClient">' . $client->name . '</a>';
                })
                ->editColumn('client_id', function ($client) {
                    return '<a href="' . route('clients.edit', ['client' => $client->id]) . '" targer="_blank" class="">
                         ' . $client->client_id . '
                    </a>';
                })
                ->editColumn('telephone', function ($client) {
                    return '<a href="' . route('clients.view_calls', ['client' => $client->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $client->telephone .
                        '</a>';
                })
                ->editColumn('active', function ($client) {
                    return $client->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->addColumn('action', function ($client) {
                    $editBtn = '<a href="' . route('insuranceCompanys.clients.edit', ['client' => $client->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateClient">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $removeBtn = '<a data-client-name="' . $client->address . '" href=' . route('insuranceCompanys.clients.delete', ['client' => $client->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteClient"
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
                ->escapeColumns([])
                // ->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'telephone', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->make();
        }
    }

    public function editClient(Request $request, Client $client)
    {

        $cities = City::all();


        $insuranceCompany = InsuranceCompany::find($client->insurance_company_id);
        $client_types = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::client_type)->get();
        $cities = City::all();
        $category = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::category)->get();
        $status = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::status)->get();
        $call=ClientCallAction::find($request->call_id);
        $createView = view('insuranceCompanys.clients.addedit'
            , [
                'client' => $client,
                'insuranceCompany' => $insuranceCompany,
                'cities' => $cities
                , 'category' => $category
                , 'status' => $status
                , 'client_types' => $client_types
                , 'call' => $call


            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function createClient(Request $request)
    {

        $cities = City::all();

        $cities = City::all();
        $category = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::category)->get();
        $status = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::status)->get();
        $call=ClientCallAction::find($request->call_id);
        $insuranceCompany = InsuranceCompany::find($request->insuranceCompany_id);
        $client_types = Constant::where('module', Modules::CLIENT)->where('field', DropDownFields::client_type)->get();


        $createView = view('insuranceCompanys.clients.addedit'
            , [
                'insuranceCompany' => $insuranceCompany,
                'cities' => $cities
                , 'category' => $category
                , 'status' => $status
                , 'call' => $call
                , 'client_types' => $client_types

            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function deleteClient(Request $request, Client $client)
    {
        try {
            $client->delete();
            return response()->json(['status' => true, 'message' => 'InsuranceCompany Deleted Successfully !']);
        }
        catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => ' Cannot delete client if it has employees or items  !'],401);
        }
    }

    public function storeClient(Request $request)
    {
        $request->validate([

            'insurance_company_id' => ['required'],


            // 'valid_from' => 'required',
        ]);
        $client = 0;
        if ($request->client_id)
            $client = Client::find($request->client_id);
        if ($client)
            $client->update($request->all());
        else
            $client = Client::create($request->all());


        return response()->json(['status' => true, 'message' => 'Client has been added successfully!']);
    }

    public function updateClient(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'insurance_company_id' => ['required'],


            // 'valid_from' => 'required',
        ]);
        $client = 0;
        if ($request->client)
            $client = Client::find($request->client);
        if ($client)
            $client->update($request->all());
        else
            $client = Client::create($request->all());


        return response()->json(['status' => true, 'message' => 'Client has been updated successfully!']);
    }

    public function getByTelephone(Request $request, $telephone)
    {

        $clients = Client::with('city', 'insuranceCompany')->where(DB::raw('RIGHT(telephone,9)'), 'like', '%' . substr($telephone, -9) . '%')->get();
        $createView =    view('insuranceCompanys.clients.getByTelephone', [
            'clientes' => $clients,
        ])->render();
        return response()->json(['createView' => $createView]);


    }
    public function viewCalls(Request $request, Client $client)
    {
        $income=CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'),'like','%'.substr($client->telephone,-9).'%')->get();
        $outcome=CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'),'like','%'.substr($client->telephone,-9).'%')->get();
        $sms=SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'),'like','%'.substr($client->telephone,-9).'%')->get();
        $callsView = view('insuranceCompanys.clients.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'client' => $client,

            ]);
        return  $callsView;
    }

}
