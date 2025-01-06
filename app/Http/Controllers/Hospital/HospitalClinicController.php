<?php

namespace App\Http\Controllers\Hospital;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\HospitalClinicAllTeamsExport;
use App\Exports\HospitalClinicsExport;
use App\Exports\HospitalClinicTeamsExport;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Constant;
use App\Models\Department;
use App\Models\Hospital;
use App\Models\HospitalClinic;
use App\Models\HospitalClinicImageType;
use App\Models\Image;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class HospitalClinicController extends Controller
{
    public function index(Request $request)
    {

        if ($request->isMethod('GET')) {
            $hospitals = Hospital::all();
            $cities = City::all();
            return view('restaurants.clinics.index', [
                'restaurants' => $hospitals,
                'cities' => $cities
            ]);
        }
        if ($request->isMethod('POST')) {
            $hosiptalClinics = HospitalClinic::with('hospital', 'department', 'serviceType')
                ->withCount('teams');

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if ($search_params['has_team'] != null) {
                    $status = $search_params['has_team'] == "YES" ? true : false;
                    if ($status)
                        $hosiptalClinics->having('teams_count', '>', 0);
                    else
                        $hosiptalClinics->having('teams_count', '=', 0);
                }

                if ($search_params['hospital_id'] != null) {
                    $hosiptalClinics->where('hospital_id', $search_params['hospital_id']);
                }
            }

            return DataTables::eloquent($hosiptalClinics)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orWhere('name_en', 'like', "%" . $value . "%");
                        $q->orWhere('name_he', 'like', "%" . $value . "%");
                    });
                })
                ->addColumn('total_teams_count', function ($hosiptalClinic) {
                    $template = ' <a href="' . route('restaurants.clinics.edit', ['hospitalClinic' => $hosiptalClinic->id, '#teams']) . '" class="menu-link px-3">
                                ' . $hosiptalClinic->teams_count . '
                            </a>';
                    return $template;
                })
                ->editColumn('created_at', function ($hosiptalClinic) {
                    return [
                        'display' => e(
                            $hosiptalClinic->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $hosiptalClinic->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($hosiptalClinic) {
                    $editBtn = '<a href="' . route('restaurants.clinics.edit', ['hospitalClinic' => $hosiptalClinic->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatehospitalClinic">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-hospitalClinic-name="' . $hosiptalClinic->name_en . '" href=' . route('restaurants.clinics.delete', ['hospitalClinic' => $hosiptalClinic->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletehospitalClinic"
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
                ->rawColumns(['total_teams_count', 'action'])
                ->make();
        }
    }

    public function create(Request $request)
    {
        $HOSPITALS = Hospital::all();
        $CLINIC_SERVICE_TYPES  = Constant::where('module', Modules::CLINIC)->where('field', DropDownFields::CLINIC_SERVICE_TYPE)
            ->get();
        $DEPARTMENTS = Department::all();
        $IMAGES = Image::active()->get();
        $SELECTED_IMAGE_TYPES = [];
        return view(
            'restaurants.clinics.addedit',
            compact('HOSPITALS', 'CLINIC_SERVICE_TYPES', 'DEPARTMENTS', 'IMAGES', 'SELECTED_IMAGE_TYPES')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            'name_he' => 'required',
            'telephone' => 'required',
            'fax' => 'required',
            'email' => 'required',
            'department_id' => 'required',
            'service_type_id' => 'required',
            'floor' => 'required',
        ]);

        $newClinic = new HospitalClinic();

        $newClinic->hospital_id = $request->hospital_id;
        $newClinic->name = $request->name;
        $newClinic->name_en = $request->name_en;
        $newClinic->name_he = $request->name_he;
        $newClinic->telephone = $request->telephone;
        $newClinic->fax = $request->fax;
        $newClinic->email = $request->email;

        $newClinic->department_id = $request->department_id;
        $newClinic->service_type_id = $request->service_type_id;
        $newClinic->building = $request->building;
        $newClinic->floor = $request->floor;

        $newClinic->diagnostic = $request->has('diagnostic') ? true : false;
        $newClinic->has_call_center = $request->has('has_call_center') ? true : false;
        $newClinic->is_department = $request->has('is_department') ? true : false;
        $newClinic->is_image_type = $request->has('is_image_type') ? true : false;
        $newClinic->view_in_chatbot = $request->has('view_in_chatbot') ? true : false;
        $newClinic->has_schedule = $request->has('has_schedule') ? true : false;
        $newClinic->status = $request->has('status') ? true : false;

        $newClinic->recommandation = $request->recommandation;

        $newClinic->save();

        $this->syncImageTypes($request, $newClinic);

        return redirect()->route('restaurants.clinics.edit', ['hospitalClinic' => $newClinic->id])->with('status', 'Clinic was successfully added!');
    }

    public function edit(Request $request, HospitalClinic $hospitalClinic)
    {
        $hospitalClinic->load('hospital', 'department', 'serviceType');
        $clinic = $hospitalClinic;
        $HOSPITALS = Hospital::all();
        $CLINIC_SERVICE_TYPES  = Constant::where('module', Modules::CLINIC)->where('field', DropDownFields::CLINIC_SERVICE_TYPE)
            ->get();
        $DEPARTMENTS = Department::all();

        $IMAGES = Image::active()->get();

        $SELECTED_IMAGE_TYPES = HospitalClinicImageType::where('hospital_clinic_id', $hospitalClinic->id)->pluck('image_id')->toArray();
        // dd( $SELECTED_IMAGE_TYPES);
        return view(
            'restaurants.clinics.addedit',
            compact('clinic', 'HOSPITALS', 'CLINIC_SERVICE_TYPES', 'DEPARTMENTS', 'IMAGES', 'SELECTED_IMAGE_TYPES')
        );
    }

    public function syncImageTypes($request, $hospitalClinic)
    {
        if ($hospitalClinic->is_image_type == true) {
            if ($request->images == null) {
                //Delete All
                $hospitalClinic->imageTypes()->delete();
            } else {
                foreach ($request->images as $imageId) {
                    if ($imageId == null)
                        continue;
                    $exists = $hospitalClinic->imageTypes()->where('image_id', $imageId)->exists();

                    if ($exists) {
                        continue;
                    }
                    $imageType = new HospitalClinicImageType();
                    $imageType->image_id = $imageId;
                    $hospitalClinic->imageTypes()->save($imageType);
                }
                // Delete unselected images
                $hospitalClinic->imageTypes()->whereNotIn('image_id', $request->images)->delete();
            }
        } else {
            $hospitalClinic->imageTypes()->delete();
        }
    }

    public function update(Request $request, HospitalClinic $hospitalClinic)
    {
        $request->validate([
            'hospital_id' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            'name_he' => 'required',
            'telephone' => 'required',
            'fax' => 'required',
            'email' => 'required',
            'department_id' => 'required',
            'service_type_id' => 'required',
            'floor' => 'required',
        ]);


        $hospitalClinic->hospital_id = $request->hospital_id;
        $hospitalClinic->name = $request->name;
        $hospitalClinic->name_en = $request->name_en;
        $hospitalClinic->name_he = $request->name_he;
        $hospitalClinic->telephone = $request->telephone;
        $hospitalClinic->fax = $request->fax;
        $hospitalClinic->email = $request->email;

        $hospitalClinic->department_id = $request->department_id;
        $hospitalClinic->service_type_id = $request->service_type_id;
        $hospitalClinic->building = $request->building;
        $hospitalClinic->floor = $request->floor;

        $hospitalClinic->diagnostic = $request->has('diagnostic') ? true : false;
        $hospitalClinic->has_call_center = $request->has('has_call_center') ? true : false;
        $hospitalClinic->is_department = $request->has('is_department') ? true : false;
        $hospitalClinic->is_image_type = $request->has('is_image_type') ? true : false;
        $hospitalClinic->view_in_chatbot = $request->has('view_in_chatbot') ? true : false;
        $hospitalClinic->has_schedule = $request->has('has_schedule') ? true : false;
        $hospitalClinic->status = $request->has('status') ? true : false;

        $hospitalClinic->recommandation = $request->recommandation;

        $this->syncImageTypes($request, $hospitalClinic);

        $hospitalClinic->save();

        return redirect()->route('restaurants.clinics.edit', ['hospitalClinic' => $hospitalClinic->id])->with('status', 'Clinic was successfully updated!');
    }

    public function updateStatus(Request $request, HospitalClinic $hospitalClinic)
    {
        if ($request->type == 'has_schedule') {
            $hospitalClinic->has_schedule = $request->status == 'true' ? true : false;
        }
        $hospitalClinic->save();

        return response()->json(['status' => true, 'message' => 'Clinic status Updated']);
    }


    public function delete(Request $request, HospitalClinic $hospitalClinic)
    {
        $hospitalClinic->delete();
        return response()->json(['status' => true, 'message' => 'Image Deleted Successfully !']);
    }

    public function getClinics(Request $request, Hospital $hospital)
    {
        $clinics = HospitalClinic::where('hospital_id', $hospital->id)->with('serviceType')->get();
        $result = [];
        $withServiceTypes = [];

        foreach ($clinics as $clinic) {
            array_push($result, ["id" => $clinic->id, 'ImageType' => $clinic->is_image_type, "text" => $clinic->name]);
            array_push($withServiceTypes, ["id" => $clinic->id, "text" => $clinic->name, 'service_type_id' => $clinic->serviceType->id, 'service_type' => $clinic->serviceType->name]);
        }

        return response()->json(['results' => $result, 'clinics' => $withServiceTypes]);
    }

    public function export(Request $request)
    {
        $name = $request->name;
        $hospital_id = $request->hospital_id;
        $has_team = $request->has_team;
        $is_active = $request->is_active;

        return Excel::download(new HospitalClinicsExport($name, $hospital_id, $has_team, $is_active), 'hospitalclinics.xlsx');
    }

    public function exportClinicTeams(Request $request)
    {
        $name = $request->name;
        $hospital_id = $request->hospital_id;
        $has_team = $request->has_team;
        $is_active = $request->is_active;

        return Excel::download(new HospitalClinicTeamsExport($name, $hospital_id, $has_team, $is_active), 'HospitalClinicTeams.xlsx');
    }

    public function exportTeams(Request $request)
    {

        return Excel::download(new HospitalClinicAllTeamsExport(), 'HospitalClinicAllTeams.xlsx');
    }
}
