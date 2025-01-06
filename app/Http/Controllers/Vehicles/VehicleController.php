<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\VehiclesExport;
use App\Http\Controllers\Controller;
use App\Models\Captin;
use App\Models\Vehicle;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;

use App\Models\Restaurant;
use App\Models\SystemSmsNotification;
use App\Models\WhatsappHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $attachmentConstants = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::attachment_rest_type)->get();
            $fuel_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::fuel_type)->get();
            $vehicle_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_type)->get();
            $vehicle_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_model)->get();
            $box_nos = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::box_no)->get();
            $promissorys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::promissory)->get();
            $insurance_companys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_company)->get();
            $policy_degrees = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_degree)->get();
            $policy_codes = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_codes)->get();
            $insurance_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_type)->get();
            $captins = Captin::all();
            $car_brands = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::brand)->get();
            $motor_cc = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::motor_cc)->get();

            return view('vehicles.index', [
                'fuel_types' => $fuel_types
                , 'motor_cc' => $motor_cc
                , 'vehicle_types' => $vehicle_types
                , 'attachmentConstants' => $attachmentConstants
                , 'vehicle_models' => $vehicle_models
                , 'box_nos' => $box_nos
                , 'captins' => $captins
                , 'car_brands' => $car_brands
                , 'promissorys' => $promissorys
                , 'insurance_companys' => $insurance_companys
                , 'policy_degrees' => $policy_degrees
                , 'policy_codes' => $policy_codes
                , 'insurance_types' => $insurance_types
            ]);
        }
        if ($request->isMethod('POST')) {
            $vehicles = Vehicle::with('vehicle_types', 'insurance_companys','insurance_types', 'motor_ccs','fuel_types','vehicle_models','captin');

            // return  $vehicles->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if (array_key_exists('vehicle_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['vehicle_type']);
                    if (count($results) > 0)
                        $vehicles->whereIn('vehicle_type', $results);
                }

                if (array_key_exists('car_brand', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['car_brand']);
                    if (count($results) > 0)
                        $vehicles->whereIn('car_brand', $results);
                }
                if (array_key_exists('fuel_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['fuel_type']);
                    if (count($results) > 0)
                        $vehicles->whereIn('fuel_type', $results);
                }
                if (array_key_exists('motor_cc', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['motor_cc']);
                    if (count($results) > 0)
                        $vehicles->whereIn('motor_cc', $results);
                }
                if ($search_params['license_expire_date2'] != null) {
                    $date = explode('to', $search_params['license_expire_date2']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $vehicles->whereBetween('license_expire_date2', [$date[0], $date[1]]);
                }

                if ($search_params['policy_expire'] != null) {
                    $date = explode('to', $search_params['policy_expire']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $vehicles->whereBetween('policy_expire', [$date[0], $date[1]]);
                }

                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $vehicles->where('active', $status);
                }


                if ($search_params['has_insurance'] != null) {
                    $status = $search_params['has_insurance'] == "YES" ? 1 : 0;
                    $vehicles->where('has_insurance', $status);
                }


                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $vehicles->where(function ($q) use ($value) {
                        $q->where('chassis_no', 'like', "%" . $value . "%");
                        $q->orwhere('vehicles.box_no', 'like', "%" . $value . "%");
                        $q->orwhere('vehicles.vehicle_no', 'like', "%" . $value . "%");
                        $q->orwhereHas('captin', function ($query) use ($value) {
                            $query->where('captins.name', 'like', "%" . $value . "%");
                        });
                    });
                }


            }

            //return $vehicles->get();
            return DataTables::eloquent($vehicles)
                ->editColumn('created_at', function ($vehicle) {
                    if ($vehicle->created_at)
                        return [
                            'display' => e(
                                $vehicle->created_at->format('m/d/Y h:i A')
                            ),
                            'timestamp' => $vehicle->created_at->timestamp
                        ];
                })
                ->editColumn('has_insurance', function ($captin) {
                    return $captin->has_insurance ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->editColumn('sign_permission', function ($captin) {
                    return $captin->sign_permission ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->editColumn('vehicle_model', function ($vehicle) {
                    return '<a href="' . route('vehicles.edit', ['vehicle' => $vehicle->id]) . '" targer="_blank" class="">
                         ' . $vehicle->vehicle_model . '
                    </a>';
                })
                ->editColumn('captin.name', function ($vehicle) {
                    if(isset($vehicle->captin))
                    return '<a href="' . route('vehicles.edit', ['vehicle' => $vehicle->id]) . '" targer="_blank" class="">
                         ' . $vehicle->captin->name . '
                    </a>';
                })
                ->editColumn('active', function ($vehicle) {
                    return $vehicle->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->addColumn('action', function ($vehicle) {
                    $editBtn = $smsAction = $callAction = $menu = '';


                    $editBtn = '<a href="' . route('vehicles.edit', ['vehicle' => $vehicle->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatevehicle">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $removeBtn = '<a data-vehicle-name="' . $vehicle->name . '" href=' . route('vehicles.delete', ['vehicle' => $vehicle->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletevehicle"
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
                //->rawColumns(['action', 'active', 'has_insurance', 'attachments_count', 'name', 'mobile1', 'intersted_in_work_insurance', 'intersted_in_health_insurance'])
                ->escapeColumns([])
                ->make();
        }
    }


    public function create(Request $request)
    {
        $attachmentConstants = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::attachment_rest_type)->get();
        $fuel_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::fuel_type)->get();
        $vehicle_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_type)->get();
        $vehicle_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_model)->get();
        $box_nos = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::box_no)->get();
        $promissorys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::promissory)->get();
        $insurance_companys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_company)->get();
        $policy_degrees = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_degree)->get();
        $policy_codes = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_codes)->get();
        $insurance_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_type)->get();
        $cities = City::all();
        $vehicle_color= Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::color)->get();
        $captins = Captin::all();
        $motor_cc = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::motor_cc)->get();
        $car_brands = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::brand)->get();
        $createView = view('vehicles.addedit', [
            'fuel_types' => $fuel_types
            , 'motor_cc' => $motor_cc
            , 'vehicle_types' => $vehicle_types
            , 'vehicle_models' => $vehicle_models
            , 'box_nos' => $box_nos
            , 'cities' => $cities
            ,'car_brands'=>$car_brands
            , 'captins' => $captins
            ,'vehicle_color'=>$vehicle_color,
             'promissorys' => $promissorys
            , 'insurance_companys' => $insurance_companys
            , 'policy_degrees' => $policy_degrees
            , 'policy_codes' => $policy_codes
            , 'insurance_types' => $insurance_types

        ])->render();
        return $createView;
    }


    public function Vehicle(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',

        ]);
        if (isset($Id)) {
            $newVehicle = Vehicle::find($Id);
            $newVehicle->update($request->all());


            $captin = Captin::find($request->captin_id);
            if ($captin)
                $captin->update($request->all());
            else {
                $captin=Captin::create($request->all());
                $newVehicle->captin_id=$captin->id;
                $newVehicle->save();
            }


        } else {


            $captin = Captin::find($request->captin_id);
            if ($captin)
                $captin->update($request->all());
            else
                $captin=Captincreate($request->all());

            $newVehicle = Vehicle::create($request->all());
            $newVehicle->captin_id=$captin->id;
            $newVehicle->save();

        }
        $captin->has_insurance = $request->has_insurance_on == 'on' ? 1 : 0;
        $captin->active = $request->active_c == 'on' ? 1 : 0;
        $captin->save();
        $newVehicle->has_insurance = $request->has_insurance_on == 'on' ? 1 : 0;
        $newVehicle->active = $request->active_c == 'on' ? 1 : 0;
        $newVehicle->save();

        $message = 'Vehicle has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Vehicle has been added successfully!']);
        else
            return redirect()->route('vehicles.index', [
                'Id' => $newVehicle->id,
                //'vehicle' => $newVehicle->id
            ])
                ->with('status', $message);
    }


    public function edit(Request $request, Vehicle $vehicle)
    {

        $attachmentConstants = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::attachment_rest_type)->get();
        $fuel_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::fuel_type)->get();
        $vehicle_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_type)->get();
        $vehicle_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_model)->get();
        $box_nos = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::box_no)->get();
        $promissorys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::promissory)->get();
        $insurance_companys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_company)->get();
        $policy_degrees = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_degree)->get();
        $policy_codes = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_codes)->get();
        $insurance_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_type)->get();
        $vehicle_color = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::color)->get();
        $car_brands = Constant::where('module', Modules::VEHICLE)->where('field', DropDownFields::brand)->get();
        $motor_cc = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::motor_cc)->get();

        $cities = City::all();
        $captins = Captin::all();
        //$messages = WhatsappHistory::getWhataaAppList([], 0, 0, 0, $vehicle->mobile1, 'Tabibfind')->orderby('time', 'desc');
        $captin=Captin::find($vehicle->captin_id);



        $createView = view('vehicles.addedit', [

                'vehicle' => $vehicle
                , 'fuel_types' => $fuel_types
                , 'motor_cc' => $motor_cc
                , 'vehicle_types' => $vehicle_types
                , 'vehicle_models' => $vehicle_models
                , 'box_nos' => $box_nos
                , 'captins' => $captins
                , 'cities' => $cities
                ,'car_brands'=>$car_brands
                , 'vehicle_color' => $vehicle_color
                , 'promissorys' => $promissorys
                , 'insurance_companys' => $insurance_companys
                , 'policy_degrees' => $policy_degrees
                , 'policy_codes' => $policy_codes
                , 'captin' => $captin
                , 'sender' => 'Tabibfind'
                , 'insurance_types' => $insurance_types
            ]


        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Vehicle $Vehicle)
    {
        $Vehicle->delete();
        return response()->json(['status' => true, 'message' => 'Vehicle Deleted Successfully !']);
    }

    public function export(Request $request)
    {

        ;
        // return $data->view();
        return Excel::download(new VehiclesExport($request->all()), 'vehicles.xlsx');
    }


    public function viewCalls(Request $request, Vehicle $vehicle)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($vehicle->mobile1, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($vehicle->mobile1, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($vehicle->mobile1, -9) . '%')->get();
        $callsView = view('vehicles.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'vehicle' => $vehicle,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewAttachments(Request $request, Vehicle $vehicle)
    {

        $callsView = view('vehicles.viewAttachments'
            , [
                'vehicle' => $vehicle,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }


}
