<?php

namespace App\Http\Controllers\Hospital;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\HospitalClinic;
use App\Models\HospitalClinicOffDay;
use App\Models\HospitalClinicSchedule;
use App\Rules\UniqueDayOfWeek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class HospitalClinicScheduleController extends Controller
{
    public function index(Request $request, HospitalClinic $hospitalClinic)
    {
        if ($request->isMethod('POST')) {
            $hosiptalClinicSchedule = HospitalClinicSchedule::query()
                ->where('hospital_clinic_id', $hospitalClinic->id)
                ->with(
                    'serviceType',
                );

            return DataTables::eloquent($hosiptalClinicSchedule)
                ->addColumn('day_of_week_name', function ($hosiptalClinicSchedule) {
                    return $hosiptalClinicSchedule->day_of_week_name;
                })
                ->editColumn('created_at', function ($hosiptalClinicSchedule) {
                    return [
                        'display' => e(
                            $hosiptalClinicSchedule->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $hosiptalClinicSchedule->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($hosiptalClinicSchedule) {
                    $editBtn = '<a href="' . route('restaurants.clinics.schedule.edit', ['hospitalClinicSchedule' => $hosiptalClinicSchedule->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatehospitalClinicSchedule">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-hospitalClinicSchedule-name="' . $hosiptalClinicSchedule->name_en . '" href=' . route('restaurants.clinics.schedule.delete', ['hospitalClinicSchedule' => $hosiptalClinicSchedule->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletehospitalClinicSchedule"
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
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function getWorkingDays(Request $req, HospitalClinic $hospitalClinic)
    {


        $startDate = Carbon::parse($req->start);
        $endDate = Carbon::parse($req->end);



        //get working days for hospital clinic
        $wokringDays = HospitalClinicSchedule::where('hospital_clinic_id', $hospitalClinic->id)->get();
        $offDays = HospitalClinicOffDay::where('hospital_clinic_id', $hospitalClinic->id)->get();
        $offDaysDates = $offDays->pluck('date')->toArray();



        $dayNames = $wokringDays->pluck('day_of_week_name')->toArray();
        $dates = [];
        $events = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {


            //Check working day and not in Day off Dates
            if (in_array($date->format('l'), $dayNames) && !in_array($date, $offDaysDates)) {
                // if ($date->format('l') === $dayName) {
                $dayIndex = array_search($date->format('l'), HospitalClinicSchedule::dayNames);
                $passed = true;

                //check Days offs in range
                foreach ($offDays->where('date', null) as $dayOff) {
                    if ($date->between($dayOff->from, $dayOff->to)) {
                        // dd('tes');
                        $events[] = [
                            'start' => $date->format('Y-m-d'),
                            'title' => 'Day Off - ' . $dayOff->reason,
                            'display' => 'background',
                            'allDay' => 'true',
                            'backgroundColor' => 'red',
                            'textColor' => '#ffffff'
                        ];
                        $passed = false;
                    }
                }

                //if passed then add to dates list
                if ($passed == true) {
                    $periodMintues = $wokringDays->where('day_of_week', $dayIndex)->first()->period_mintues;
                    $dates[] = ['date' => $date->toDateString(), 'dayIndex' => $dayIndex, 'periodMintues' => $periodMintues];
                }
            }


            if (in_array($date, $offDaysDates)) {
                $events[] = [
                    'start' => $date->format('Y-m-d'),
                    'title' => 'Day Off',
                    'display' => 'background',
                    'allDay' => 'true',
                    'backgroundColor' => 'red',
                    'textColor' => '#ffffff'
                ];
            }
        }



        foreach ($dates as $value) {
            $date = $value['date'];
            $startFrom = $wokringDays->where('day_of_week', $value['dayIndex'])->first()->from;
            $to = $wokringDays->where('day_of_week', $value['dayIndex'])->first()->to;
            $periodMintues = $value['periodMintues'];

            $start = Carbon::parse($date . ' ' . $startFrom);
            $end = Carbon::parse($date . ' ' . $to);
            $counter = 0;

            $events[] = [
                'start' => $start->toIso8601String(),
                'end' => $start->copy()->addMinutes($periodMintues)->toIso8601String(),
                'title' => 'Session ' . ++$counter,
                'durationEditable' => false
            ];

            for ($time = $start->copy()->addMinutes($periodMintues); $time->lt($end); $time->addMinutes($periodMintues)) {
                $event = [
                    'start' => $time->toIso8601String(),
                    'end' => $time->copy()->addMinutes($periodMintues)->toIso8601String(),
                    'title' => 'Session ' . ++$counter,
                    'durationEditable' => false
                ];
                $events[] = $event;
            }
        }

        return response()->json($events);
    }

    public function create(Request $request, HospitalClinic $hospitalClinic)
    {
        $ServiceType = Constant::where('module', Modules::CLINIC)->where('field', DropDownFields::CLINIC_SERVICE_TYPE)->get();
        $DayOfWeek = HospitalClinicSchedule::dayNames;

        $createView =  view('restaurants.clinics.schedule.addedit_modal', [
            'hospitalClinic' => $hospitalClinic,
            'ServiceType' => $ServiceType,
            'DayOfWeek' => $DayOfWeek
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request, HospitalClinic $hospitalClinic)
    {
        $request->validate([
            'service_type_id' => 'required',
            'day_of_week' => ['required', new UniqueDayOfWeek($hospitalClinic->id)],
            'from' => 'required',
            'to' => 'required',
            'period_mintues' => 'required',
            // 'valid_from' => 'required',
        ]);


        $newSchedule = new HospitalClinicSchedule();
        $newSchedule->hospital_clinic_id = $hospitalClinic->id;
        $newSchedule->procedures = $request->procedures;
        $newSchedule->service_type_id = $request->service_type_id;
        $newSchedule->day_of_week = $request->day_of_week;
        $newSchedule->from = $request->from;
        $newSchedule->to = $request->to;
        $newSchedule->period_mintues = $request->period_mintues;
        $newSchedule->max_patients = $this->CalculateNumberOfPatients($request->from, $request->to, $request->period_mintues);

        $newSchedule->save();

        return response()->json(['status' => true, 'message' => 'Schedule has been added successfully!']);
    }

    private function CalculateNumberOfPatients($from, $to, $period_mintues)
    {
        $start = Carbon::createFromTimeString($from);
        $end = Carbon::createFromTimeString($to);
        $startWithDate = Carbon::now()->setTime($start->hour, $start->minute, $start->second);
        $endWithDate = Carbon::now()->setTime($end->hour, $end->minute, $end->second);
        $durationInMinutes = $endWithDate->diffInMinutes($startWithDate);
        $numberOfSessions = intval($durationInMinutes / $period_mintues);
        return $numberOfSessions;
    }


    public function edit(Request $request, HospitalClinicSchedule $hospitalClinicSchedule)
    {
        $ServiceType = Constant::where('module', Modules::CLINIC)->where('field', DropDownFields::CLINIC_SERVICE_TYPE)->get();
        $DayOfWeek = HospitalClinicSchedule::dayNames;

        $createView =  view('restaurants.clinics.schedule.addedit_modal', [
            'clinic_schedule' => $hospitalClinicSchedule,
            'ServiceType' => $ServiceType,
            'DayOfWeek' => $DayOfWeek
        ])->render();
        return response()->json(['createView' => $createView]);
    }

    public function update(Request $request, HospitalClinicSchedule $hospitalClinicSchedule)
    {
        $request->validate([
            'service_type_id' => 'required',
            'day_of_week' => 'required',
            'from' => 'required',
            'to' => 'required',
            'period_mintues' => 'required',
            // 'valid_from' => 'required',
        ]);

        $hospitalClinicSchedule->procedures = $request->procedures;
        $hospitalClinicSchedule->service_type_id = $request->service_type_id;
        $hospitalClinicSchedule->day_of_week = $request->day_of_week;
        $hospitalClinicSchedule->from = $request->from;
        $hospitalClinicSchedule->to = $request->to;
        $hospitalClinicSchedule->period_mintues = $request->period_mintues;
        $hospitalClinicSchedule->max_patients = $this->CalculateNumberOfPatients($request->from, $request->to, $request->period_mintues);
        $hospitalClinicSchedule->save();

        return response()->json(['status' => true, 'message' => 'Schedule has been updated successfully!']);
    }



    public function delete(Request $request, HospitalClinicSchedule $hospitalClinicSchedule)
    {
        $hospitalClinicSchedule->delete();
        return response()->json(['status' => true, 'message' => 'Schedule Deleted Successfully !']);
    }
}
