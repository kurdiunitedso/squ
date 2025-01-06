<?php

namespace App\Http\Controllers\Complains;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Complain;
use App\Models\ComplainTypeAnswer;
use App\Models\Constant;
use App\Models\Patient;
use App\Models\PatientClinicTeam;
use App\Models\User;
use App\PatientService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ComplainController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('complains.index');
        }
        if ($request->isMethod('POST')) {

            $currentDate = date('Y-m-d');

            $totalStats = DB::table('complains')
                ->selectRaw("count(case when status = 'in process' and complain_date = '$currentDate' then 1 end) as new_complains_count")
                ->selectRaw("count(case when status = 'in process' then 1 end) as in_process")
                ->selectRaw("count(case when status = 'solved' then 1 end) as solved")
                ->where('deleted_at', null)
                ->first();
            $totalStats = get_object_vars($totalStats);

            $complains = Complain::with(
                'patient',
                'assignedUser',
                'source',
                'user',
            )->select('complains.*');
            if ($request->input('params')) {
                $search_params = $request->input('params');
                if ($search_params['status'] != null) {
                    $status = $search_params['status'];
                    if ($status == 'status_new_complains') {
                        $complains->where('status', 'in process');
                        $complains->where('complain_date', $currentDate);
                    }
                    if ($status == 'status_in_process') {
                        $complains->where('status', 'in process');
                    }
                    if ($status == 'status_solved') {
                        $complains->where('status', 'solved');
                    }
                }
            }

            return DataTables::eloquent($complains)
                ->editColumn('source', function ($complain) {
                    if ($complain->source == null)
                        return 'CRM';

                    $actionModel = $complain->source->getMorphClass();
                    $Module = class_basename($actionModel);
                    $route = route('patient_calls_actions.create', ['patient_id' => $complain->patient_id, 'patientCallAction' => $complain->source->id]);
                    $link = '<a href="' . $route . '">' . 'CallAction' . '-' . $complain->source->id . '</a>';
                    return $link;
                })
                ->addColumn('complain_type', function ($complain) {
                    $result = [];
                    $complainTypes = ComplainTypeAnswer::where('complain_id', $complain->id)
                        ->with('complainType')
                        ->get();
                    if ($complainTypes->count() > 0) {
                        // dd($complainTypes);
                        foreach ($complainTypes as $type) {
                            array_push($result, $type->complainType->name);
                        }
                    }

                    return $result;
                })
                ->addColumn('delay', function ($complain) {
                    $delay = $complain->delay;
                    return $delay;
                })
                ->editColumn('complain_date', function ($complain) {
                    if ($complain->complain_date == null)
                        return '';
                    return $complain->complain_date->format('Y-m-d');
                })
                ->addColumn('action', function ($complain) {

                    $assignBtn  = '';
                    if (Auth::user()->hasRole('super-admin')) {
                        $assignBtn = '<a href="' . route('complains.assignUser', ['complain' => $complain->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnAssginUser">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    }

                    $statusBtn = '<a href="' . route('complains.changeStatus', ['complain' => $complain->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnChangeStatus">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor"/>
                    <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM12 16.8C11 16.8 10.2 16.4 9.5 15.8C8.8 15.1 8.5 14.3 8.5 13.3C8.5 12.8 8.59999 12.3 8.79999 11.9L10 13.1V10.1C10 9.50001 9.6 9.10001 9 9.10001H6L7.29999 10.4C6.79999 11.3 6.5 12.2 6.5 13.3C6.5 14.8 7.10001 16.2 8.10001 17.2C9.10001 18.2 10.5 18.8 12 18.8C12.6 18.8 13 18.3 13 17.8C13 17.2 12.6 16.8 12 16.8ZM16.7 16.2C17.2 15.3 17.5 14.4 17.5 13.3C17.5 11.8 16.9 10.4 15.9 9.39999C14.9 8.39999 13.5 7.79999 12 7.79999C11.4 7.79999 11 8.19999 11 8.79999C11 9.39999 11.4 9.79999 12 9.79999C12.9 9.79999 13.8 10.2 14.5 10.8C15.2 11.5 15.5 12.3 15.5 13.3C15.5 13.8 15.4 14.3 15.2 14.7L14 13.5V16.5C14 17.1 14.4 17.5 15 17.5H18L16.7 16.2Z" fill="currentColor"/>
                    <path opacity="0.3" d="M12 16.8C11 16.8 10.2 16.4 9.5 15.8C8.8 15.1 8.5 14.3 8.5 13.3C8.5 12.8 8.59999 12.3 8.79999 11.9L7.29999 10.4C6.79999 11.3 6.5 12.2 6.5 13.3C6.5 14.8 7.10001 16.2 8.10001 17.2C9.10001 18.2 10.5 18.8 12 18.8C12.6 18.8 13 18.3 13 17.8C13 17.2 12.6 16.8 12 16.8Z" fill="currentColor"/>
                    <path opacity="0.3" d="M15.5 13.3C15.5 13.8 15.4 14.3 15.2 14.7L16.7 16.2C17.2 15.3 17.5 14.4 17.5 13.3C17.5 11.8 16.9 10.4 15.9 9.39999C14.9 8.39999 13.5 7.79999 12 7.79999C11.4 7.79999 11 8.19999 11 8.79999C11 9.39999 11.4 9.79999 12 9.79999C12.9 9.79999 13.8 10.2 14.5 10.8C15.1 11.5 15.5 12.4 15.5 13.3Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $editBtn = $this->editButton(
                        route('complains.create', [
                            'patient_id' => $complain->patient_id,
                            'Id' => $complain->id,
                            'complain' => $complain->id
                        ]),
                        'btnUpdatecomplain'
                    );

                    $deleteMsg = ' Complain for <b>Patient Name</b> : ' .
                        $complain->patient->name_locale;
                    if ($complain->complain_date != null) {
                        $deleteMsg .= ' <b>Complain Date</b> :' .
                            $complain->complain_date->format('Y-m-d');
                    }

                    $removeBtn = $this->deleteButton(
                        route('complains.delete', ['complain' => $complain->id]),
                        'btnDeletecomplain',
                        'data-complain-name="' . $deleteMsg  . '"'
                    );
                    return $assignBtn . $statusBtn . $editBtn . $removeBtn;
                })
                ->rawColumns(['source', 'action'])
                ->with('new_complains_count', $totalStats['new_complains_count'])
                ->with('in_process_count', $totalStats['in_process'])
                ->with('solved_count', $totalStats['solved'])
                ->make();
        }
    }

    public function create(Request $request)
    {
        $Constants = Constant::where('module', Modules::Patient)->get();
        $ALHAYAT_BRANCHES = $Constants->Where('field', DropDownFields::ALHAYAT_BRANCHES);
        $MARITAL_STATUS = $Constants->Where('field', DropDownFields::MARITAL_STATUS);
        $MEMBERSHIP_TYPE = $Constants->Where('field', DropDownFields::MEMBERSHIP_TYPE);
        $MEMBERSHIP_SUBTYPE = $Constants->Where('field', DropDownFields::MEMBERSHIP_SUBTYPE);
        $SICK_FUND = $Constants->Where('field', DropDownFields::SICK_FUND);

        $IDENTITY_TYPES = Constant::where('module', Modules::main_module)->where('field', DropDownFields::IDENTITY_TYPE)->get();

        $CITIES = City::all();
        $BLOOD_TYPE = DropDownFields::BLOOD_TYPE;


        $complainTypes = Constant::where('module', Modules::COMPLAIN)->where('field', DropDownFields::COMPLAIN_TYPE)->get();
        $PatientClinicTeamTitles = Constant::where('module', Modules::CLINIC)
            ->whereIn('name', ['Clinic Team', 'Medical Team'])->get();
        $clinicTeam = PatientClinicTeam::where('title_type_id', $PatientClinicTeamTitles->where('name', 'Clinic Team')->first()->id)->get();
        $medicalTeam = PatientClinicTeam::where('title_type_id', $PatientClinicTeamTitles->where('name', 'Medical Team')->first()->id)->get();

        $complainTypes = $complainTypes->map(function ($item) use ($PatientClinicTeamTitles) {
            if ($item->name == 'Clinic Team')
                return $PatientClinicTeamTitles->where('name', 'Clinic Team')->first();
            if ($item->name == 'Medical Team')
                return $PatientClinicTeamTitles->where('name', 'Medical Team')->first();

            return $item;
        });


        $patientForm = '';
        $patient = null;
        $complain = null;
        $HospitalClinics = null;
        $SELECTED_COMPLAIN_TYPES = [];
        $complainClinicTeams = [];
        $complainMedicalTeams = [];



        if ($request->has('complain')) {
            $complain = Complain::find($request->get('complain'));

            $complainTypeAnswers = ComplainTypeAnswer::where('complain_id', $complain->id)->get();
            $SELECTED_COMPLAIN_TYPES = $complainTypeAnswers->pluck('complain_type_id')->toArray();

            $complainClinicTeams = $complainTypeAnswers
                ->whereIn('patient_clinic_team_id', $clinicTeam
                    ->pluck('id')
                    ->toArray())
                ->pluck('patient_clinic_team_id')->toArray();
            $complainMedicalTeams = $complainTypeAnswers
                ->whereIn('patient_clinic_team_id', $medicalTeam
                    ->pluck('id')
                    ->toArray())
                ->pluck('patient_clinic_team_id')->toArray();
        }

        if ($request->has('patient_id')) {
            $patient = Patient::find($request->get('patient_id'));
            $patientForm = view('patients.form', [
                'ALHAYAT_BRANCHES' => $ALHAYAT_BRANCHES,
                'MARITAL_STATUS' => $MARITAL_STATUS,
                'MEMBERSHIP_TYPE' => $MEMBERSHIP_TYPE,
                'MEMBERSHIP_SUBTYPE' => $MEMBERSHIP_SUBTYPE,
                'IDENTITY_TYPES' => $IDENTITY_TYPES,
                'CITIES' => $CITIES,
                'BLOOD_TYPE' => $BLOOD_TYPE,
                'SICK_FUND' => $SICK_FUND,
                'patient' => $patient
            ])->render();
        } else {
            $patientForm = view('patients.form', [
                'ALHAYAT_BRANCHES' => $ALHAYAT_BRANCHES,
                'MARITAL_STATUS' => $MARITAL_STATUS,
                'MEMBERSHIP_TYPE' => $MEMBERSHIP_TYPE,
                'MEMBERSHIP_SUBTYPE' => $MEMBERSHIP_SUBTYPE,
                'IDENTITY_TYPES' => $IDENTITY_TYPES,
                'CITIES' => $CITIES,
                'BLOOD_TYPE' => $BLOOD_TYPE,
                'SICK_FUND' => $SICK_FUND,
            ])->render();
        }

        $complainStatuses = ['in process', 'solved'];



        $systemUsers = User::active()->get();

        return view('complains.addedit', compact(
            'patientForm',
            'patient',
            'complain',
            'complainStatuses',
            'complainTypes',
            'SELECTED_COMPLAIN_TYPES',
            'systemUsers',
            'clinicTeam',
            'medicalTeam',
            'complainClinicTeams',
            'complainMedicalTeams',
        ));
    }

    public function Complain(Request $request, $Id = null)
    {
        // dd($request->all());
        $patient_id = null;
        $complain = null;

        $request->validate([
            'complain_date' => 'required',
            'complain_status' => 'required',
            'complain' => 'required',
            //=-=-=-=-=
            'id_type' => 'required',
            'idcard_no' => [
                'required',
                Rule::unique('patients')->ignore($request->patient_id)
            ],
            'register' => 'required|max:50',
            'register_date' => 'required|date',
            'name' => 'required|max:50',
            'name_en' => 'required|max:50',
            'name_he' => 'required|max:50',
            'birth_date' => 'required|date',
            'branch_id' => 'required|numeric',
            'marital_status_id' => 'required|numeric',
            'blood_type' => 'required|string|max:3',
            'gender' => 'required',
            'mobile' => 'required|max:15',
            'tel1' => 'required|max:15',
            'membership_type' => 'required|numeric',
            'membership_subtype' => 'required|numeric',
            'clinical_history' => 'nullable|max:255',
            'email' => 'nullable|email',
        ]);


        $complainTypes = Constant::where('module', Modules::CLINIC)
            ->whereIn('name', ['Clinic Team', 'Medical Team'])->get();

        if ($request->has('patient_id')) {

            $complain =  Complain::updateOrCreate(
                ['id' => $Id],
                [
                    'patient_id' => $request->patient_id,
                    'complain_date' => $request->complain_date,
                    'complain' => $request->complain,
                    'assigned_user_id' => $request->assigned_user_id,
                    'status' => $request->complain_status,
                    'user_id' => Auth::user()->id,
                ]
            );
            $patient = Patient::find($request->patient_id);

            PatientService::Update($request, $patient);

            $complain->load('typeAnswers');
            //Complain Type Answer


            if ($request->has('complain_type_id')) {
                $currentComplainTypeIds = $complain->typeAnswers()->get();
                $detachComplainTypeIds = collect([]);
                $attachComplainTypeIds = collect([]);

                foreach ($request->complain_type_id as $requestComplainType) {
                    // clinic_team_id
                    // medical_team_id
                    $complainType = $complainTypes->where('id', $requestComplainType)->first();
                    if ($complainType != null) {
                        $teamId = null;
                        if ($complainType->name == 'Clinic Team') {
                            $teamId = $request->clinic_team_id;
                        } else if ($complainType->name == 'Medical Team') {
                            $teamId = $request->medical_team_id;
                        }
                        //check if it's already exists, if it's already exists bu not sent deleted it
                        if ($teamId != null)
                            $attachComplainTypeIds->push([
                                'complain_id' => $complain->id,
                                'complain_type_id' => $requestComplainType,
                                'patient_clinic_team_id' => $teamId,
                            ]);
                    } else {
                        $attachComplainTypeIds->push([
                            'complain_id' => $complain->id,
                            'complain_type_id' => $requestComplainType,
                            'patient_clinic_team_id' => null,
                        ]);
                    }
                }
                // dd($currentComplainTypeIds, $attachComplainTypeIds);
                foreach ($currentComplainTypeIds as $currentItem) {
                    $attachId = $attachComplainTypeIds
                        ->where('complain_id', $currentItem['complain_id'])
                        ->where('complain_type_id', $currentItem['complain_type_id'])
                        ->where('patient_clinic_team_id', $currentItem['patient_clinic_team_id'])->first();
                    if ($attachId != null) {
                        if (
                            $currentItem['complain_id'] != $attachId['complain_id']
                            && $currentItem['complain_type_id'] != $attachId['complain_type_id']
                            && $currentItem['patient_clinic_team_id'] != $attachId['patient_clinic_team_id']
                        ) {
                            //exists
                            $detachComplainTypeIds->push($currentItem);
                        }
                    } else
                        $detachComplainTypeIds->push($currentItem);
                }
                $complain->typeAnswers()->whereIn('id', $detachComplainTypeIds->pluck('id')->toArray())->delete();

                foreach ($attachComplainTypeIds as $type) {
                    ComplainTypeAnswer::updateOrCreate([
                        'complain_id' => $complain->id,
                        'complain_type_id' => $type['complain_type_id'],
                        'patient_clinic_team_id' => $type['patient_clinic_team_id'],
                    ], [
                        'complain_id' => $complain->id,
                        'complain_type_id' => $type['complain_type_id'],
                        'patient_clinic_team_id' => $type['patient_clinic_team_id'],
                    ]);
                }
            } else
                $complain->typeAnswers()->delete();

            $message = "";

            $complain != null ? $message = "Complain was successfully Updated!" : $message = "Complain was successfully added!";
            return redirect()->route('complains.create', [
                'patient_id' => $request->patient_id,
                'Id' => $complain->id,
                'complain' => $complain->id
            ])
                ->with('status', $message);
        } else {
            $patient = PatientService::Create($request);

            $complain =  Complain::updateOrCreate(
                ['id' => $Id],
                [
                    'patient_id' => $patient->id,
                    'complain_date' => $request->complain_date,
                    'complain' => $request->complain,
                    'assigned_user_id' => $request->assigned_user_id,
                    'status' => $request->complain_status,
                    'user_id' => Auth::user()->id,
                ]
            );

            //Complain Type Answer

            $complain->load('typeAnswers');
            //Complain Type Answer
            if ($request->has('complain_type_id')) {
                $currentComplainTypeIds = $complain->typeAnswers()->get();
                $detachComplainTypeIds = collect([]);
                $attachComplainTypeIds = collect([]);

                foreach ($request->complain_type_id as $requestComplainType) {
                    // clinic_team_id
                    // medical_team_id
                    $complainType = $complainTypes->where('id', $requestComplainType)->first();
                    if ($complainType != null) {
                        $teamId = null;
                        if ($complainType->name == 'Clinic Team') {
                            $teamId = $request->clinic_team_id;
                        } else if ($complainType->name == 'Medical Team') {
                            $teamId = $request->medical_team_id;
                        }
                        //check if it's already exists, if it's already exists bu not sent deleted it
                        if ($teamId != null)
                            $attachComplainTypeIds->push([
                                'complain_id' => $complain->id,
                                'complain_type_id' => $requestComplainType,
                                'patient_clinic_team_id' => $teamId,
                            ]);
                    } else {
                        $attachComplainTypeIds->push([
                            'complain_id' => $complain->id,
                            'complain_type_id' => $requestComplainType,
                            'patient_clinic_team_id' => null,
                        ]);
                    }
                }
                // dd($currentComplainTypeIds, $attachComplainTypeIds);
                foreach ($currentComplainTypeIds as $currentItem) {
                    $attachId = $attachComplainTypeIds
                        ->where('complain_id', $currentItem['complain_id'])
                        ->where('complain_type_id', $currentItem['complain_type_id'])
                        ->where('patient_clinic_team_id', $currentItem['patient_clinic_team_id'])->first();
                    if ($attachId != null) {
                        if (
                            $currentItem['complain_id'] != $attachId['complain_id']
                            && $currentItem['complain_type_id'] != $attachId['complain_type_id']
                            && $currentItem['patient_clinic_team_id'] != $attachId['patient_clinic_team_id']
                        ) {
                            //exists
                            $detachComplainTypeIds->push($currentItem);
                        }
                    } else
                        $detachComplainTypeIds->push($currentItem);
                }
                $complain->typeAnswers()->whereIn('id', $detachComplainTypeIds->pluck('id')->toArray())->delete();

                foreach ($attachComplainTypeIds as $type) {
                    ComplainTypeAnswer::updateOrCreate([
                        'complain_id' => $complain->id,
                        'complain_type_id' => $type['complain_type_id'],
                        'patient_clinic_team_id' => $type['patient_clinic_team_id'],
                    ], [
                        'complain_id' => $complain->id,
                        'complain_type_id' => $type['complain_type_id'],
                        'patient_clinic_team_id' => $type['patient_clinic_team_id'],
                    ]);
                }
            } else
                $complain->typeAnswers()->delete();

            $message = "";

            $complain != null ? $message = "Complain was successfully Updated!" : $message = "Complain was successfully added!";
            return redirect()->route('complains.create', [
                'patient_id' => $patient->id,
                'Id' => $complain->id,
                'complain' => $complain->id
            ])
                ->with('status', $message);
        }
    }

    public function assignUser(Request $request, Complain $complain)
    {
        if ($request->isMethod('GET')) {
            $systemUsers = User::active()->get();
            $complain->load('patient');
            $createView = view('complains.AssignUser_modal', ['complain' => $complain, 'systemUsers' => $systemUsers])->render();
            return response()->json([
                'createView' => $createView
            ]);
        }
        if ($request->isMethod('POST')) {

            $request->validate([
                'assigned_user_id' => 'required',
            ]);

            $complain->assigned_user_id = $request->assigned_user_id;
            $complain->save();

            return response()->json(['status' => true, 'message' => 'User assigned successfully']);
        }
    }

    public function changeStatus(Request $request, Complain $complain)
    {
        if ($request->isMethod('GET')) {
            $complainStatuses = ['in process', 'solved'];
            $complain->load('patient');
            $createView = view('complains.changeStatus_modal', ['complain' => $complain, 'complainStatuses' => $complainStatuses])->render();
            return response()->json([
                'createView' => $createView
            ]);
        }
        if ($request->isMethod('POST')) {

            $request->validate([
                'complain_status' => 'required',
            ]);

            $complain->status = $request->complain_status;
            $complain->save();

            return response()->json(['status' => true, 'message' => 'Complain status updated successfully']);
        }
    }


    public function delete(Request $request, Complain $complain)
    {
        $complain->delete();
        return response()->json(['status' => true, 'message' => 'Complain Deleted Successfully !']);
    }
}
