<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\DoctorsExport;
use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\PatientClinic;
use App\Models\Speciality;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class DoctorController extends Controller
{


    public function index(Request $request)
    {

        if ($request->isMethod('GET')) {

            $Constants = Constant::where('module', Modules::Patient)->get();
            $SICK_FUNDS = $Constants->Where('field', DropDownFields::SICK_FUND);

            $PATIENT_CLINICS = PatientClinic::all();

            return view(
                'doctors.index',
                [
                    'sick_funds' => $SICK_FUNDS,
                    'PATIENT_CLINICS' => $PATIENT_CLINICS,
                ]
            );
        }
        if ($request->isMethod('POST')) {
            $doctors = Doctor::with(
                'speciality',
                'hospital',
                'patientClinic',
                'country',
                'city',
            );

            if ($request->input('params')) {
                $search_params = $request->input('params');

                if ($search_params['sick_funds'] != null) {
                    $doctors->whereHas('patientClinic', function ($query) use ($search_params) {
                        $query->where('sick_fund_id', $search_params['sick_funds']);
                    });
                }

                if ($search_params['patient_clinic_id'] != null) {
                    $doctors->where('patient_clinic_id', $search_params['patient_clinic_id']);
                }

                if ($search_params['has_schedule'] != null) {
                    $status = $search_params['has_schedule'] == "YES" ? true : false;
                    $doctors->where('has_schedule', $status);
                }
                if ($search_params['is_active'] != null) {
                    $status = $search_params['is_active'] == "YES" ? true : false;
                    $doctors->where('status', $status);
                }
            }



            return DataTables::eloquent($doctors)
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%" . $value . "%");
                        $q->orWhere('name_en', 'like', "%" . $value . "%");
                        $q->orWhere('name_he', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('created_at', function ($doctor) {
                    return [
                        'display' => e(
                            $doctor->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $doctor->created_at->timestamp
                    ];
                })
                ->editColumn('hospitalName', function ($doctor) {
                    return $doctor->hospital ?  $doctor->hospital->name_locale : '';
                })
                ->addColumn('action', function ($doctor) {
                    $editBtn = '<a href="' . route('doctors.edit', ['doctor' => $doctor->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateDoctor">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-Doctor-name="' . $doctor->name . '" href=' . route('doctors.delete', ['doctor' => $doctor->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteDoctor"
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
    public function getDoctors(Request $request)
    {
        $doctors = Doctor::with(
            'speciality',
            'patientClinic',
            'country',
            'city',
            'schedule'
        );
        return DataTables::eloquent($doctors)
            // ->filterColumn('name', function ($query, $keyword) use ($request) {
            //     $columns = $request->input('columns');
            //     $value = $columns[1]['search']['value'];
            //     $query->where(function ($q) use ($value) {
            //         $q->where('name', 'like', "%" . $value . "%");
            //         $q->orWhere('name_en', 'like', "%" . $value . "%");
            //         $q->orWhere('name_he', 'like', "%" . $value . "%");
            //     });
            // })
            // ->editColumn('created_at', function ($doctor) {
            //     return [
            //         'display' => e(
            //             $doctor->created_at->format('m/d/Y h:i A')
            //         ),
            //         'timestamp' => $doctor->created_at->timestamp
            //     ];
            // })
            ->editColumn('hospitalName', function ($doctor) {
                return $doctor->hospital ?  $doctor->hospital->name_locale : '';
            })
            ->editColumn('patientClinic.name_locale', function ($doctor) {
                if (isset($doctor->patientClinic))
                    return $doctor->patientClinic->name_locale;
                else return '';
            })
            ->editColumn('working_days', function ($doctor) {
                $html = '<ul>';
                foreach ($doctor->schedule as $workingDay) {
                    # code...
                    $html .= '<li>' . $workingDay->day_of_week_name . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('action', function ($doctor) {
                $showShedule = '<a href="' . route('doctors.schedule.GetDoctorScheduleAppts', ['doctor' => $doctor->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnSelectDoctor"
                data-doctor-id="' . $doctor->id . '"
                >
                    <span class="svg-icon svg-icon-3">
                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M19 3.40002C18.4 3.40002 18 3.80002 18 4.40002V8.40002H14V4.40002C14 3.80002 13.6 3.40002 13 3.40002C12.4 3.40002 12 3.80002 12 4.40002V8.40002H8V4.40002C8 3.80002 7.6 3.40002 7 3.40002C6.4 3.40002 6 3.80002 6 4.40002V8.40002H2V4.40002C2 3.80002 1.6 3.40002 1 3.40002C0.4 3.40002 0 3.80002 0 4.40002V19.4C0 20 0.4 20.4 1 20.4H19C19.6 20.4 20 20 20 19.4V4.40002C20 3.80002 19.6 3.40002 19 3.40002ZM18 10.4V13.4H14V10.4H18ZM12 10.4V13.4H8V10.4H12ZM12 15.4V18.4H8V15.4H12ZM6 10.4V13.4H2V10.4H6ZM2 15.4H6V18.4H2V15.4ZM14 18.4V15.4H18V18.4H14Z" fill="currentColor"/>
                    <path d="M19 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V4.40002C0 5.00002 0.4 5.40002 1 5.40002H19C19.6 5.40002 20 5.00002 20 4.40002V1.40002C20 0.800024 19.6 0.400024 19 0.400024Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                return $showShedule;
            })
            ->rawColumns(['action', 'working_days'])
            ->make();
    }

    public function create(Request $request)
    {
        $DoctorTypes  = Constant::where('module', Modules::DOCTOR)
            ->where('field', DropDownFields::DOCTOR_TYPE)->get();
        $Specialities = Speciality::all();
        $HOSPITALS = Hospital::all();
        $PatientClincs = PatientClinic::all();
        $Departments = Department::all();
        $Countries = Country::all();

        return view(
            'doctors.addedit',
            compact(
                'DoctorTypes',
                'Specialities',
                'HOSPITALS',
                'PatientClincs',
                'Departments',
                'Countries',
            )
        );
    }

    public function getDoctorByNameOrId(Request $request)
    {
        $searchTerm = $request->get('q');
        $Doctors = Doctor::where(function ($q) use ($searchTerm) {
            $q->orWhere('name', 'like', "%" . $searchTerm . "%");
            $q->orWhere('name_en', 'like', "%" . $searchTerm . "%");
            $q->orWhere('name_he', 'like', "%" . $searchTerm . "%");
        })
            ->where('status', true)
            ->paginate(10);

        $result = collect($Doctors->items())->map(function ($item, $key) {
            return ["id" => $item->id, "text" => $item->name_locale];
        });

        return response()->json(['items' => $result, 'page' => $Doctors->currentPage(), 'total_count' => $Doctors->total()]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'name_he' => 'required',
            'email' => 'required',
            'speciality_id' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        $newDoctor = new Doctor();

        $newDoctor->name = $request->name;
        $newDoctor->name_en = $request->name_en;
        $newDoctor->name_he = $request->name_he;
        $newDoctor->mobile = $request->mobile;
        $newDoctor->telephone = $request->telephone;
        $newDoctor->email = $request->email;
        $newDoctor->speciality_id = $request->speciality_id;
        $newDoctor->hospital_id = $request->hospital_id;
        $newDoctor->patient_clinic_id = $request->patient_clinic_id;
        $newDoctor->country_id = $request->country_id;
        $newDoctor->city_id = $request->city_id;

        $newDoctor->has_schedule = $request->has('has_schedule') ? true : false;
        $newDoctor->status = $request->has('status') ? true : false;

        $newDoctor->save();

        return redirect()->route('doctors.edit', ['doctor' => $newDoctor->id])->with('status', 'Doctor was successfully added!');
    }

    public function edit(Request $request, Doctor $doctor)
    {

        $doctor->load(
            'speciality',
            'hospital',
            'patientClinic',
            'country',
            'city'
        );


        $DoctorTypes  = Constant::where('module', Modules::DOCTOR)
            ->where('field', DropDownFields::DOCTOR_TYPE)->get();
        $Specialities = Speciality::all();
        $HOSPITALS = Hospital::all();
        $PatientClincs = PatientClinic::all();
        $Departments = Department::all();
        $Countries = Country::all();
        $Cities  = City::where('country_id', $doctor->country_id)->get();

        return view(
            'doctors.addedit',
            compact(
                'doctor',
                'DoctorTypes',
                'Specialities',
                'HOSPITALS',
                'PatientClincs',
                'Departments',
                'Countries',
                'Cities'
            )
        );
    }




    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'name_he' => 'required',
            'email' => 'required',
            'speciality_id' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        $doctor->name = $request->name;
        $doctor->name_en = $request->name_en;
        $doctor->name_he = $request->name_he;
        $doctor->mobile = $request->mobile;
        $doctor->telephone = $request->telephone;
        $doctor->email = $request->email;
        $doctor->speciality_id = $request->speciality_id;
        $doctor->hospital_id = $request->hospital_id;
        $doctor->patient_clinic_id = $request->patient_clinic_id;
        $doctor->country_id = $request->country_id;
        $doctor->city_id = $request->city_id;

        $doctor->status = $request->has('status') ? true : false;
        $doctor->has_schedule = $request->has('has_schedule') ? true : false;

        $doctor->save();

        return redirect()->route('doctors.edit', ['doctor' => $doctor->id])->with('status', 'Doctor was successfully updated!');
    }

    public function updateStatus(Request $request, Doctor $doctor)
    {
        if ($request->type == 'has_schedule') {
            $doctor->has_schedule = $request->status == 'true' ? true : false;
        }
        $doctor->save();

        return response()->json(['status' => true, 'message' => 'Doctor status Updated']);
    }

    public function delete(Request $request, Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(['status' => true, 'message' => 'Doctor Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        $name = $request->name;
        $sick_funds = $request->sick_fund_id;
        $patient_clinic_id = $request->patient_clinic_id;
        $has_schedule = $request->has_schedule;
        $is_active = $request->is_active;

        return Excel::download(new DoctorsExport($name, $sick_funds, $patient_clinic_id, $has_schedule, $is_active), 'doctors.xlsx');
    }
}
