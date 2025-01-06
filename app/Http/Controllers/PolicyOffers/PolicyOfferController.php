<?php

namespace App\Http\Controllers\PolicyOffers;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\PolicyOffersExport;
use App\Http\Controllers\Controller;
use App\Models\Captin;
use App\Models\PolicyOffer;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;

use App\Models\Restaurant;
use App\Models\SystemSmsNotification;
use App\Models\Vehicle;
use App\Models\WhatsappHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PolicyOfferController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $attachmentConstants = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::attachment_rest_type)->get();

            $fuel_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::fuel_type)->get();
            $vehicle_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_type)->get();
            $vehicle_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_model)->get();
            $policyOffer_types = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::policyOffer_type)->get();
            $box_nos = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::box_no)->get();
            $promissorys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::promissory)->get();
            $insurance_companys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_company)->get();
            $policy_degrees = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_degree)->get();
            $policy_codes = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_codes)->get();
            $insurance_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_type)->get();
            $captins = Captin::all();
            $accident_descs = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::accident_desc)->get();
            $mortgaged_types = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::mortgaged_type)->get();
            $status_ids = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::status)->get();
            $car_brands = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::brand)->get();
            $motor_cc = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::motor_cc)->get();
            $cities = City::all();
            return view('policyOffers.index', [
                'fuel_types' => $fuel_types
                , 'motor_cc' => $motor_cc
                , 'cities ' => $cities

                , 'policyOffer_types' => $policyOffer_types
                , 'attachmentConstants' => $attachmentConstants
                , 'vehicle_models' => $vehicle_models
                , 'vehicle_types' => $vehicle_types
                , 'box_nos' => $box_nos
                , 'captinss' => $captins
                , 'car_brands' => $car_brands
                , 'status_ids' => $status_ids
                , 'mortgaged_types' => $mortgaged_types
                , 'accident_descs' => $accident_descs

                , 'promissorys' => $promissorys
                , 'insurance_companys' => $insurance_companys
                , 'policy_degrees' => $policy_degrees
                , 'policy_codes' => $policy_codes
                , 'insurance_types' => $insurance_types
            ]);
        }
        if ($request->isMethod('POST')) {
            $policyOffers = PolicyOffer::with('policyOffer_types', 'vehicle', 'insuranceCompany', 'captin', 'status')
                ->withCount('attachments');

            // return  $policyOffers->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if (array_key_exists('vehicle_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['vehicle_type']);
                    if (count($results) > 0)
                        $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                            $query->whereIn('vehicle_type', $results);
                        });
                }

                if (array_key_exists('car_brand', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['car_brand']);
                    if (count($results) > 0)
                        $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                            $query->whereIn('car_brand', $results);
                        });
                }
                if (array_key_exists('fuel_type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['fuel_type']);
                    if (count($results) > 0)
                        $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                            $query->whereIn('fuel_type', $results);
                        });
                }
                if (array_key_exists('motor_cc', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['motor_cc']);
                    if (count($results) > 0)
                        $policyOffers->orwhereHas('vehicle', function ($query) use ($results) {
                            $query->whereIn('motor_cc', $results);
                        });
                }
                if ($search_params['license_expire_date2'] != null) {
                    $date = explode('to', $search_params['license_expire_date2']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $policyOffers->orwhereHas('vehicle', function ($query) use ($date) {
                        $query->whereBetween('license_expire_date2', [$date[0], $date[1]]);
                    });

                }

                if ($search_params['policy_expire'] != null) {
                    $date = explode('to', $search_params['policy_expire']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $policyOffers->orwhereHas('vehicle', function ($query) use ($date) {
                        $query->whereBetween('policy_expire', [$date[0], $date[1]]);
                    });

                }

                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? 1 : 0;
                    $policyOffers->where('active', $status);
                }


                /*     if ($search_params['has_insurance'] != null) {
                         $status = $search_params['has_insurance'] == "YES" ? 1 : 0;
                         $policyOffers->where('has_insurance', $status);
                     }*/


                if ($search_params['search'] != null) {
                    $value = $search_params['search'];
                    $policyOffers->where(function ($q) use ($value) {
                        $q->orwhereHas('vehicle', function ($query) use ($value) {
                            $query->where('chassis_no', 'like', "%" . $value . "%");
                            $query->orwhere('vehicles.box_no', 'like', "%" . $value . "%");
                            $query->orwhere('vehicles.policyOffer_no', 'like', "%" . $value . "%");
                        });
                        $q->orwhereHas('captin', function ($query) use ($value) {
                            $query->where('captins.name', 'like', "%" . $value . "%");
                        });
                    });
                }


            }

            //return $policyOffers->get();
            return DataTables::eloquent($policyOffers)
                ->editColumn('has_insurance', function ($captin) {
                    return $captin->has_insurance ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->editColumn('sign_permission', function ($captin) {
                    return $captin->sign_permission ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->editColumn('vehicle.vehicle_model', function ($policyOffer) {
                    if (isset($policyOffer->vehicle))
                        return '<a href="' . route('policyOffers.edit', ['policyOffer' => $policyOffer->id]) . '" targer="_blank" class="">
                         ' . $policyOffer->vehicle->vehicle_model . '
                    </a>';

                })
                ->editColumn('captin.name', function ($policyOffer) {
                    if (isset($policyOffer->captin))
                        return '<a href="' . route('policyOffers.edit', ['policyOffer' => $policyOffer->id]) . '" targer="_blank" class="">
                         ' . $policyOffer->captin->name . '
                    </a>';
                })
                ->editColumn('attachments_count', function ($policyOffer) {
                    return '<a href="' . route('policyOffers.view_attachments', ['policyOffer' => $policyOffer->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $policyOffer->attachments_count . '
                    </a>';
                })
                ->editColumn('created_at', function ($policyOffer) {
                    return Carbon::parse($policyOffer->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('captin.mobile1', function ($policyOffer) {
                    if ($policyOffer->captin) {
                        $captin = $policyOffer->captin;
                        return '<a href="' . route('captins.view_calls', ['captin' => $captin->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                            . $captin->mobile1 .
                            '</a>';
                    }
                })
                ->editColumn('active', function ($policyOffer) {
                    return $policyOffer->active ? '<h4 class="text text-success">Yes</h4>' : '<h4 class="text text-danger">No</h4>';
                })
                ->addColumn('action', function ($policyOffer) {
                    $editBtn = $smsAction = $callAction = $menu = '';


                    $editBtn = '<a href="' . route('policyOffers.edit', ['policyOffer' => $policyOffer->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatepolicyOffer">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $removeBtn = '<a data-policyOffer-name="' . $policyOffer->name . '" href=' . route('policyOffers.delete', ['policyOffer' => $policyOffer->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletepolicyOffer"
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
        $attachmentConstants = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::attachment_rest_type)->get();
        $fuel_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::fuel_type)->get();
        $policyOffer_types = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::policyOffer_type)->get();
        $vehicle_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_type)->get();
        $vehicle_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_model)->get();
        $accident_descs = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::accident_desc)->get();
        $mortgaged_types = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::mortgaged_type)->get();
        $status_ids = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::status)->get();
        //  $policyOffer_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policyOffer_model)->get();
        $box_nos = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::box_no)->get();
        $promissorys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::promissory)->get();
        $insurance_companys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_company)->get();
        $policy_degrees = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_degree)->get();
        $policy_codes = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_codes)->get();
        $insurance_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_type)->get();
        $cities = City::all();
        $policyOffer_color = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::color)->get();
        $captins = Captin::all();
        $motor_cc = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::motor_cc)->get();
        $car_brands = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::brand)->get();
        $createView = view('policyOffers.addedit', [
            'fuel_types' => $fuel_types
            , 'motor_cc' => $motor_cc
            , 'policyOffer_types' => $policyOffer_types
            , 'vehicle_models' => $vehicle_models
            , 'vehicle_types' => $vehicle_types
            , 'box_nos' => $box_nos
            , 'cities' => $cities
            , 'vehicles' => []
            , 'status_ids' => $status_ids
            , 'mortgaged_types' => $mortgaged_types
            , 'accident_descs' => $accident_descs

            , 'car_brands' => $car_brands
            , 'captins' => $captins
            , 'policyOffer_color' => $policyOffer_color,
            'promissorys' => $promissorys
            , 'insurance_companys' => $insurance_companys
            , 'policy_degrees' => $policy_degrees
            , 'policy_codes' => $policy_codes
            , 'insurance_types' => $insurance_types

        ])->render();
        return $createView;
    }


    public function PolicyOffer(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required',

        ]);
        if (isset($Id)) {
            $newPolicyOffer = PolicyOffer::find($Id);
            $newPolicyOffer->update($request->all());


            $captin = Captin::find($request->captin_id);
            if ($captin)
                $captin->update($request->all());
            else {
                $captin=Captin::create($request->all());
                $newPolicyOffer->captin_id = $captin->id;
                $newPolicyOffer->save();
            }

            $vehicle = Vehicle::find($request->vehicle_id);
            if ($vehicle)
                $vehicle->update($request->all());
            else {
                $vehicle=Vehicle::create($request->all());
                $newPolicyOffer->vehicle_id = $vehicle->id;
                $newPolicyOffer->save();
            }


        } else {


            $captin = Captin::find($request->captin_id);
            if ($captin)
                $captin->update($request->all());
            else
                $captin=Captin::create($request->all());

            $vehicle = Vehicle::find($request->vehicle_id);
            if ($vehicle)
                $vehicle->update($request->all());
            else
                $vehicle=Vehicle::create($request->all());

            $newPolicyOffer = PolicyOffer::create($request->all());
            $newPolicyOffer->captin_id = $captin->id;
            $newPolicyOffer->save();

        }



        $vehicle->has_insurance = $request->has_insurance_on == 'on' ? 1 : 0;
        $vehicle->save();

        $newPolicyOffer->drivers_under_24 = $request->drivers_under_24_c == 'on' ? 1 : 0;
        $newPolicyOffer->has_accidents = $request->has_accidents_c == 'on' ? 1 : 0;
        $newPolicyOffer->active = $request->active_c_policy == 'off' ? 1 : 0;
        $newPolicyOffer->is_mortgaged = $request->is_mortgaged_c == 'on' ? 1 : 0;
        $newPolicyOffer->work_transport = $request->work_transport_c == 'off' ? 1 : 0;
        $newPolicyOffer->save();

        $message = 'PolicyOffer has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'PolicyOffer has been added successfully!']);
        else
            return redirect()->route('policyOffers.edit', ['policyOffer' => $newPolicyOffer->id]);

    }


    public function edit(Request $request, PolicyOffer $policyOffer)
    {

        $attachmentConstants = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::attachment_rest_type)->get();
        $fuel_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::fuel_type)->get();
        $policyOffer_types = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::policyOffer_type)->get();
        // $policyOffer_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policyOffer_model)->get();
        $box_nos = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::box_no)->get();
        $promissorys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::promissory)->get();
        $insurance_companys = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_company)->get();
        $policy_degrees = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_degree)->get();
        $policy_codes = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::policy_codes)->get();
        $insurance_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::insurance_type)->get();
        $policyOffer_color = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::color)->get();
        $car_brands = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::brand)->get();
        $motor_cc = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::motor_cc)->get();
        $vehicle_types = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_type)->get();
        $vehicle_models = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::vehicle_model)->get();
        $accident_descs = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::accident_desc)->get();
        $mortgaged_types = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::mortgaged_type)->get();
        $status_ids = Constant::where('module', Modules::POLICYOFFER)->where('field', DropDownFields::status)->get();


        $captin_image = $policyOffer->attachments()->where('attachment_type_id', 307)->orderBy('id', 'desc')->get()->first();
        $driving_license = $policyOffer->attachments()->where('attachment_type_id', 308)->orderBy('id', 'desc')->get()->first();

        $vehicle_right_view = $policyOffer->attachments()->where('attachment_type_id', 311)->orderBy('id', 'desc')->get()->first();
        $vehicle_left_view = $policyOffer->attachments()->where('attachment_type_id', 312)->orderBy('id', 'desc')->get()->first();
        $vehicle_front_view = $policyOffer->attachments()->where('attachment_type_id', 309)->orderBy('id', 'desc')->get()->first();
        $vehicle_back_view = $policyOffer->attachments()->where('attachment_type_id', 310)->orderBy('id', 'desc')->get()->first();

        $vehicle_license_front_view = $policyOffer->attachments()->where('attachment_type_id', 314)->orderBy('id', 'desc')->get()->first();
        $vehicle_license_back_view = $policyOffer->attachments()->where('attachment_type_id', 315)->orderBy('id', 'desc')->get()->first();
        $chasses_image = $policyOffer->attachments()->where('attachment_type_id', 313)->orderBy('id', 'desc')->get()->first();

        $cities = City::all();
        $captins = Captin::all();
        //$messages = WhatsappHistory::getWhataaAppList([], 0, 0, 0, $policyOffer->telephone, 'Tabibfind')->orderby('time', 'desc');
        $captin = Captin::find($policyOffer->captin_id);
        $vehicle = Vehicle::find($policyOffer->captin_id);


        $createView = view('policyOffers.addedit', [

                'policyOffer' => $policyOffer
                , 'fuel_types' => $fuel_types
                , 'motor_cc' => $motor_cc
                , 'captin_image' => $captin_image
                , 'driving_license' => $driving_license
                , 'policyOffer_types' => $policyOffer_types
                , 'vehicle_models' => $vehicle_models
                , 'vehicle_types' => $vehicle_types
                , 'box_nos' => $box_nos
                , 'captins' => $captins
                , 'cities' => $cities
                , 'status_ids' => $status_ids
                , 'mortgaged_types' => $mortgaged_types
                , 'accident_descs' => $accident_descs
                , 'vehicles' => isset($captin) ? Vehicle::where('captin_id', $captin->id)->get() : []
                , 'car_brands' => $car_brands
                , 'policyOffer_color' => $policyOffer_color
                , 'promissorys' => $promissorys
                , 'insurance_companys' => $insurance_companys
                , 'policy_degrees' => $policy_degrees
                , 'policy_codes' => $policy_codes
                , 'captin' => $captin
                , 'vehicle' => Vehicle::find($policyOffer->vehicle_id)
                , 'sender' => 'Tabibfind'
                , 'chasse_image' => $chasses_image
                , 'vehicle_license_back_view' => $vehicle_license_back_view
                , 'vehicle_license_front_view' => $vehicle_license_front_view
                , 'vehicle_back_view' => $vehicle_back_view
                , 'vehicle_front_view' => $vehicle_front_view
                , 'vehicle_right_view' => $vehicle_right_view
                , 'vehicle_left_view' => $vehicle_left_view
                , 'insurance_types' => $insurance_types
            ]


        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, PolicyOffer $policyOffer)
    {
        //$policyOffer= PolicyOffer::find($policyOffer);
        $policyOffer->delete();
        return response()->json(['status' => true, 'message' => 'PolicyOffer Deleted Successfully !']);
    }

    public function export(Request $request)
    {

        ;
        // return $data->view();
        return Excel::download(new PolicyOffersExport($request->all()), 'policyOffers.xlsx');
    }


    public function viewCalls(Request $request, PolicyOffer $policyOffer)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($policyOffer->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($policyOffer->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($policyOffer->telephone, -9) . '%')->get();
        $callsView = view('policyOffers.viewCalls'
            , [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'policyOffer' => $policyOffer,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewAttachments(Request $request, PolicyOffer $policyOffer)
    {

        $callsView = view('policyOffers.attachments.indexP'
            , [
                'policyOffer' => $policyOffer,

            ])->render();
        return response()->json(['createView' => $callsView]);
    }


}
