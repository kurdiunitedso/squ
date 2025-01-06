<?php

namespace App\Http\Controllers;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\CallQuestionnaire;
use App\Models\Constant;
use App\Models\MarketingCall;
use App\Models\MarketingCallAction;
use App\Models\MarketingCqResponse;
use App\Models\Patient;
use App\Models\PatientClinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class MarketingCallController extends Controller
{
    public function index(Request $request)
    {


        if ($request->isMethod('GET')) {
            return view('marketing.index');
        } else if ($request->isMethod('POST')) {

            $currentDate = date('Y-m-d');


            $totalStatsMarketingCalls = DB::table('marketing_calls')
                ->selectRaw("count(case when marketing_calls.next_call_date = '$currentDate' then 1 end) as total_next_call_today")
                ->selectRaw("count(case when marketing_calls.status = 'Waiting' then 1 end) as total_waiting")
                ->selectRaw("count(case when marketing_calls.status = 'Completed' then 1 end) as total_completed")
                ->selectRaw("count(case when patients.patient_status = 'leaving patients' then 1 end) as total_leaving_patients")
                ->selectRaw("count(case when patients.patient_status = 'newly joined' then 1 end) as total_newly_joined")
                ->selectRaw("count(case when marketing_calls.call_action_id = 115 then 1 end) as total_no_answer") //115 Not answered
                ->leftJoin('patients', 'marketing_calls.patient_id', '=', 'patients.id')
                ->where('marketing_calls.deleted_at', null)
                ->where('patients.deleted_at', null)
                ->when(!Auth::user()->hasRole('super-admin'), function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->first();



            $totalStatsMarketingCalls = get_object_vars($totalStatsMarketingCalls);


            $MarketingCalls = MarketingCall::whereHas('patient', function ($query) use ($request) {
                $query->select("patients.*", DB::raw('floor(DATEDIFF(CURDATE(),birth_date) /365) AS years_old'))
                    ->withCount('short_messages')
                    ->withCount('parents')
                    ->withCount('relatives')
                    ->with(['marketingCalls' => function ($query) {
                        $query->with('callAction')->latest()->limit(1);
                    }]);
                if ($request->input('params')) {
                    $search_params = $request->input('params');
                    if ($search_params['status'] != null) {
                        $status = $search_params['status'];
                        if ($status == 'total_leaving_patients') {
                            $query->where('patient_status', 'leaving patients');
                        }
                        if ($status == 'total_newly_joined') {
                            $query->where('patient_status', 'newly joined');
                        }
                    }
                }
            })
                ->with(['callAction', 'patient', 'patient.membershipType', 'patient.membershipSubtype', 'patient.branch', 'patient.documentType', 'patient.city', 'patient.next_call', 'patient.last_call'])
                ->with('user')
                ->select('marketing_calls.*');

            if (!Auth::user()->hasRole('super-admin')) {
                $MarketingCalls->where('user_id', Auth::user()->id);
            }


            if ($request->input('params')) {
                $search_params = $request->input('params');
                if ($search_params['status'] != null) {
                    $status = $search_params['status'];
                    if ($status == 'total_waiting') {
                        $MarketingCalls->where('status', 'Waiting');
                    }
                    if ($status == 'total_completed') {
                        $MarketingCalls->where('status', 'Completed');
                    }
                    if ($status == 'total_no_answer') {
                        $MarketingCalls->where('call_action_id', 115);
                    }
                    if ($status == 'total_next_call_today') {
                        $MarketingCalls->where('next_call_date', $currentDate);
                    }
                }
            }


            // dd($patients->get());
            return DataTables::eloquent($MarketingCalls)
                ->filterColumn('patient.name', function ($query, $keyword) use ($request) {
                    $columns = $request->input('columns');
                    $value = $columns[1]['search']['value'];
                    $query->whereHas('patient', function ($patientQuery) use ($value) {
                        $patientQuery->where(function ($q) use ($value) {
                            $q->where('name', 'like', "%" . $value . "%");
                            $q->orWhere('name_en', 'like', "%" . $value . "%");
                            $q->orWhere('name_he', 'like', "%" . $value . "%");
                            $q->orWhere('idcard_no', 'like', "%" . $value . "%");
                            $q->orWhere('mobile', 'like', "%" . $value . "%");
                        });
                    });
                })
                ->addColumn('total_relatives_count', function ($marketingCall) {
                    $total_relatives = $marketingCall->patient->total_parents_count + $marketingCall->patient->total_relatives_count;
                    $template = ' <a href="' . route('patients.relatives', ['patient' => $marketingCall->patient->id]) . '" class="menu-link px-3">
                                    ' . $total_relatives . '
                                </a>';
                    return $template;
                })
                ->addColumn('marketingCall_created_at', function ($marketingCall) {
                    $createdDate = $marketingCall->created_at->format('Y-m-d');
                    return $createdDate;
                })
                // ->addColumn('marketing_call_status', function ($marketingCall) {
                //     $template = isset($marketingCall->patient->marketingCalls) && !empty($marketingCall->patient->marketingCalls->toArray()) ? $marketingCall->patient->marketingCalls->first()->callAction->name : '';
                //     return $template;
                // })

                ->addColumn('call_action_text', function ($marketingCall) {
                    $template = isset($marketingCall->callAction) ? $marketingCall->callAction->name : '';
                    return $template;
                })
                ->editColumn('patient.name', function ($marketingCall) {
                    return '<a href="' . route('patients.edit', ['patient' => $marketingCall->patient->id]) . '">' . $marketingCall->patient->name . '</a>';
                })

                ->editColumn('patient.mobile', function ($marketingCall) {
                    return '<a href="' . route('patients.patient_calls_sms_logs', ['patient' => $marketingCall->patient->id]) . '" class="ShowPatientCallsSmsLogs">' . $marketingCall->patient->mobile . '</a>';
                })
                ->editColumn('patient.last_call', function ($marketingCall) {
                    $route = "#";
                    if (Auth::user()->can('patient_call_access')) {
                        $route =  route('patients.calls.view_patients_calls', ['patient' => $marketingCall->patient->id]);
                    }

                    $lastCall = "";
                    if ($marketingCall->patient->last_call != null)
                        $lastCall = $marketingCall->patient->last_call->created_at->format('d/m/Y') . '(' . $marketingCall->patient->calls_count . ')';

                    // return $route;
                    return '<a class="showCalls" href="' . $route . '">' . $lastCall . '</a>';
                })
                ->editColumn('patient.next_call', function ($marketingCall) {
                    return isset($marketingCall->patient->next_call) ? $marketingCall->patient->next_call->next_call->format('d/m/Y') : '';
                })
                ->editColumn('patient.birth_date', function ($marketingCall) {
                    return [
                        'display' => e(
                            $marketingCall->patient->birth_date->format('d/m/Y')
                        ),
                        'timestamp' => $marketingCall->patient->birth_date->timestamp
                    ];
                })
                ->editColumn('patient.register_date', function ($marketingCall) {
                    return [
                        'display' => e(
                            $marketingCall->patient->register_date->format('d/m/Y')
                        ),
                        'timestamp' => $marketingCall->patient->register_date->timestamp
                    ];
                })
                ->editColumn('created_at', function ($marketingCall) {
                    return [
                        'display' => e(
                            $marketingCall->created_at->format('Y-m-d')
                        ),
                        'timestamp' => $marketingCall->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($marketingCall) {
                    $menu =   $callAction =  $removeBtn =   $editBtn =  $smsAction = $viewPatient = '';
                    if (Auth::user()->canAny(['patient_register_history_access', 'patient_sms_access', 'patient_call_access', 'patient_edit'])) {
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
                        if (Auth::user()->can('patient_edit')) {
                            $menu .= '
                                    <div class="menu-item px-3">
                                    <a href="' . route('patients.createValidation', ['patient' => $marketingCall->patient->id]) . '" class="menu-link px-3 AddPatientValidation" data-kt-patients-table-actions="show_register_history">
                                            Make Validation
                                        </a>
                                    </div>';
                        }
                        if (Auth::user()->can('patient_call_access')) {
                            $menu .= '
                                    <div class="menu-item px-3">
                                        <a href="' . route('patients.calls.view_patients_calls', ['patient' => $marketingCall->patient->id]) . '" class="menu-link px-3 showCalls" data-kt-patients-table-actions="show_calls">
                                            Show Calls (' . ($marketingCall->patient->total_calls_count + $marketingCall->patient->total_marketing_calls_count)  . ')
                                        </a>
                                    </div>';
                        }
                        if (Auth::user()->can('patient_sms_access')) {

                            $menu .= '
                                    <!--end::Menu item-->
                                    <div class="menu-item px-3">
                                    <a href="' . route('patients.sms.view_patients_sms', ['patient' => $marketingCall->patient->id]) . '" class="menu-link px-3 showSms" data-kt-patients-table-actions="showSms">
                                        Show SMS (' . $marketingCall->patient->total_short_messages_count . ')
                                    </a>
                                    <!--end::Menu item-->
                                    </div>';
                        }
                        if (Auth::user()->can('patient_edit')) {

                            $menu .= '
                                    <div class="menu-item px-3">
                                    <a href="' . route('patients.relatives', ['patient' => $marketingCall->patient->id]) . '" class="menu-link px-3">
                                        Show Relatives
                                    </a>
                                    </div>
                                    <div class="menu-item px-3">
                                    <a href="' . route('patients.attachments', ['patient' => $marketingCall->patient->id]) . '" class="menu-link px-3">
                                        Show Attachments
                                    </a>
                                    </div>';
                        }
                        $menu .= '
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                ';
                    }

                    if (Auth::user()->can('marketing_add')) {
                        $callAction = '<a class="btn btn-icon btn-active-light-primary w-30px h-30px btnAddPatientCall" href="' . route('marketing_calls.calls_action.call_action_create', ['patient' => $marketingCall->patient->id, 'marketingCall' => $marketingCall->id]) . '">
                                <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"
                                    />
                                </svg>
                                </span>
                            </a>
                            ';
                    }
                    if (Auth::user()->can('patient_view')) {
                        $viewPatient = '<a href=' . route('patients.edit', ['patient' => $marketingCall->patient->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                            <span class="svg-icon svg-icon-3">
                            <svg width="26" height="28" viewBox="0 0 26 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.8254 27.3337H4.17203C3.1536 27.3337 2.17688 26.9291 1.45674 26.2089C0.736602 25.4888 0.332031 24.5121 0.332031 23.4937V4.50699C0.332031 3.48856 0.736602 2.51184 1.45674 1.7917C2.17688 1.07156 3.1536 0.666992 4.17203 0.666992H17.8254C18.8438 0.666992 19.8205 1.07156 20.5407 1.7917C21.2608 2.51184 21.6654 3.48856 21.6654 4.50699V23.4937C21.6654 24.5121 21.2608 25.4888 20.5407 26.2089C19.8205 26.9291 18.8438 27.3337 17.8254 27.3337ZM10.9987 7.33366C10.4713 7.33366 9.95571 7.49006 9.51718 7.78307C9.07865 8.07609 8.73685 8.49257 8.53502 8.97984C8.33319 9.46711 8.28038 10.0033 8.38327 10.5206C8.48616 11.0378 8.74014 11.513 9.11308 11.8859C9.48602 12.2589 9.96117 12.5129 10.4785 12.6158C10.9957 12.7186 11.5319 12.6658 12.0192 12.464C12.5065 12.2622 12.9229 11.9204 13.216 11.4818C13.509 11.0433 13.6654 10.5277 13.6654 10.0003C13.6654 9.29308 13.3844 8.6148 12.8843 8.11471C12.3842 7.61461 11.7059 7.33366 10.9987 7.33366ZM15.3587 19.3337C15.5794 19.347 15.8 19.3052 16.0005 19.2121C16.2011 19.1189 16.3753 18.9774 16.5076 18.8002C16.6398 18.623 16.7259 18.4157 16.7581 18.1969C16.7903 17.9781 16.7676 17.7548 16.692 17.547C16.2027 16.4571 15.3998 15.5378 14.3858 14.9061C13.3718 14.2744 12.1926 13.9591 10.9987 14.0003C9.81328 13.9677 8.64459 14.2856 7.63898 14.9141C6.63337 15.5426 5.83553 16.4538 5.34537 17.5337C4.9987 18.4003 5.70536 19.3337 7.38536 19.3337H15.3587ZM24.332 12.667H22.9987V18.0003H24.332C24.6857 18.0003 25.0248 17.8598 25.2748 17.6098C25.5249 17.3598 25.6654 17.0206 25.6654 16.667V14.0003C25.6654 13.6467 25.5249 13.3076 25.2748 13.0575C25.0248 12.8075 24.6857 12.667 24.332 12.667ZM24.332 4.66699H22.9987V10.0003H24.332C24.6857 10.0003 25.0248 9.85985 25.2748 9.6098C25.5249 9.35975 25.6654 9.02061 25.6654 8.66699V6.00033C25.6654 5.6467 25.5249 5.30756 25.2748 5.05752C25.0248 4.80747 24.6857 4.66699 24.332 4.66699Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </a>';
                    }


                    return  $menu . $callAction  . $viewPatient;
                })
                ->rawColumns(['total_relatives_count', 'patient.last_call', 'patient.mobile', 'patient.name', 'action'])
                ->with('total_next_call_today', $totalStatsMarketingCalls['total_next_call_today'])
                ->with('total_waiting', $totalStatsMarketingCalls['total_waiting'])
                ->with('total_completed', $totalStatsMarketingCalls['total_completed'])
                ->with('total_leaving_patients', $totalStatsMarketingCalls['total_leaving_patients'])
                ->with('total_newly_joined', $totalStatsMarketingCalls['total_newly_joined'])
                ->with('total_no_answer', $totalStatsMarketingCalls['total_no_answer'])
                ->make();
        }
    }

    public function call_action_create(Request $request, Patient $patient, MarketingCall $marketingCall)
    {

        $callActions = Constant::where('field',  DropDownFields::CALL_ACTION)->where('module', Modules::MARKETING)->get();
        $callPatientActions = ['Waiting', 'Completed'];
        $SICK_FUND = Constant::where('field',  DropDownFields::SICK_FUND)->where('module', Modules::Patient)->get();
        $questionnaires = CallQuestionnaire::all();
        $PATIENT_CLINICS = PatientClinic::all();
        $EMPLOYEES = [];

        if (Auth::user()->hasRole('super-admin')) {
            $EMPLOYEES = User::all();
        } else {
            $EMPLOYEES = User::where('id', Auth::user()->id)->get();
        }

        $createView = view('marketing.calls_addedit_modal', [
            'marketingCall' => $marketingCall,
            'patient' => $patient,
            'CALL_ACTION' => $callActions,
            'CALL_PATIENT_ACTIONS' => $callPatientActions,
            'EMPLOYEES' => $EMPLOYEES,
            'questionnaires' => $questionnaires,
            'SICK_FUND' => $SICK_FUND,
            'PATIENT_CLINICS' => $PATIENT_CLINICS
        ])->render();
        return response()->json(['createView' => $createView]);
    }

    private function EnsureUserId($user_id)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $user_id;
        } else {
            return Auth::user()->id;
        }
    }


    public function call_action_store(Request $request, Patient $patient, MarketingCall $marketingCall)
    {
        $request->validate([
            'call_action_id' => 'required',
            'patient_action_id' => 'required',
            'patient_clinic_id' => 'required',
            'sick_fund_id' => 'required',
            'validation_date' => 'required',
            'user_id' => Rule::requiredIf(Auth::user()->hasRole('super-admin')),
            'next_call' => 'required',
            'notes' => 'required',
        ]);

        $newCall = new MarketingCallAction();

        $newCall->marketing_call_id = $marketingCall->id;
        $newCall->patient_id = $patient->id;
        $newCall->call_action_id = $request->call_action_id;
        $newCall->status = $request->patient_action_id;
        $newCall->user_id = $this->EnsureUserId($request->user_id);
        $newCall->next_call = $request->next_call;
        $newCall->sick_fund_id = $request->sick_fund_id;
        $newCall->patient_clinic_id = $request->patient_clinic_id;
        $newCall->validation_date = $request->validation_date;
        $newCall->notes = $request->notes;

        $marketingCall->status = $request->patient_action_id;
        $marketingCall->next_call_date = $request->next_call;
        $marketingCall->call_action_id = $request->call_action_id;

        $marketingCall->save();
        $newCall->save();

        if ($request->has('call_questionnaire')) {
            foreach ($request->call_questionnaire as $call_questionnaire_key => $questionIds) {
                foreach ($questionIds['questionId'] as $quetionId => $questionResponse) {
                    MarketingCqResponse::create([
                        'marketing_call_action_id' => $newCall->id,
                        'patient_id' => $patient->id,
                        'call_questionnaire_id' => $call_questionnaire_key,
                        'cq_question_id' => $quetionId,
                        'answer' => $questionResponse
                    ]);
                }
            }
        }

        return response()->json(['status' => true, 'message' => 'Call has been added successfully!']);
    }


    public function scheduleCalls(Request $request)
    {
        $request->validate([
            'patientIds' => 'required|array',
            'employee_id' => 'required',
            'kt_schedule_range' => 'required',
            'minimun_calls_per_day' => 'required'
        ]);

        $date = explode('to', $request->kt_schedule_range);
        if (count($date) == 1) $date[1] = $date[0];
        // $patients->whereBetween('register_date', [$date[0], $date[1]]);
        // dd($request->all());
        $employeeId = $request->employee_id;
        $kt_schedule_range = $request->kt_schedule_range;
        $excluding_days = $request->excluding_days;
        $minimun_calls_per_day = $request->minimun_calls_per_day;


        if (!isset($excluding_days))
            $excluding_days = [];


        $patientList = Patient::whereIn('id', $request->patientIds)->get();

        return  $this->generateCallSchedule(
            $employeeId,
            $kt_schedule_range,
            $excluding_days,
            $minimun_calls_per_day,
            $patientList,
        );
    }


    public function generateCallSchedule(
        $employeeId,
        $kt_schedule_range,
        $excludingDays,
        $minimun_calls_per_day,
        $patientList
    ) {


        $date = explode(' to ', $kt_schedule_range);
        if (count($date) == 1) $date[1] = $date[0];
        $startDate = \Carbon\Carbon::parse($date[0]);
        $endDate = \Carbon\Carbon::parse($date[1]);

        // Create an array of days to exclude

        // Calculate the number of days excluding specified days
        $numberOfDays = $startDate->diffInDaysFiltered(function ($date) use ($excludingDays) {
            return !in_array($date->englishDayOfWeek, $excludingDays);
        }, $endDate) + 1; // Include the end date

        // Assuming you have a list of 50 patients

        // Calculate calls per day
        $callsPerDay = intval($minimun_calls_per_day);


        // Calculate the total calls needed
        $totalCalls = $numberOfDays * $callsPerDay;

        // Generate the call schedule
        $callSchedule = [];

        $callDate = $startDate->copy();
        $remainingPatients = $patientList->count();
        $patientIndex = 0;

        while ($callDate->lte($endDate)) {
            if (!in_array($callDate->englishDayOfWeek, $excludingDays)) {
                $calls = min($callsPerDay, $remainingPatients);

                for ($i = 0; $i < $calls; $i++) {
                    $callSchedule[] = [
                        'patient_id' => $patientList[$patientIndex]->id,
                        'next_call_date' => $callDate->format('Y-m-d'),
                        'user_id' => $employeeId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $remainingPatients--;
                    $patientIndex++;

                    if ($patientIndex >= count($patientList)) {
                        $patientIndex = 0;
                    }
                }
            }

            $callDate->addDay();
        }

        //if callSchedule doesn't have all the patients then it fails the results
        $callSchedulePatientsCountable = collect($callSchedule);
        $patients = $callSchedulePatientsCountable->pluck('patient_id');
        if ($patients->count() < $patientList->count()) {
            // dd('error');
            return response()->json(['message' => 'The patients total count cant fit within the date range you provided'], 400);
        }

        // Make the saving
        MarketingCall::insert($callSchedule);

        // Return the generated call schedule
        return response()->json(['message' => 'Call schedules successfully created for ']);
        // return $callSchedule;
    }
}
