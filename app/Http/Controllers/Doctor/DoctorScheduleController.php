<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Doctor;
use App\Models\DoctorOffDay;
use App\Models\DoctorSchedule;
use App\Models\InternalAppointment;
use App\Rules\UniqueDayOfWeekDoctor;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DoctorScheduleController extends Controller
{
    public function index(Request $request, Doctor $doctor)
    {
        if ($request->isMethod('POST')) {
            $doctorSchedule = DoctorSchedule::query()
                ->where('doctor_id', $doctor->id)
                ->with(
                    'serviceType',
                );

            return DataTables::eloquent($doctorSchedule)
                ->addColumn('day_of_week_name', function ($doctorSchedule) {
                    return $doctorSchedule->day_of_week_name;
                })
                ->editColumn('created_at', function ($doctorSchedule) {
                    return [
                        'display' => e(
                            $doctorSchedule->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $doctorSchedule->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($doctorSchedule) {
                    $editBtn = '<a href="' . route('doctors.schedule.edit', ['doctorSchedule' => $doctorSchedule->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatedoctorSchedule">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $removeBtn = '<a data-doctorSchedule-name="' . $doctorSchedule->name_en . '" href=' . route('doctors.schedule.delete', ['doctorSchedule' => $doctorSchedule->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletedoctorSchedule"
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

    public function getWorkingDates(Request $request, Doctor $doctor)
    {
        $wokringDays = DoctorSchedule::where('doctor_id', $doctor->id)->get();
        $DoctoroffDays = DoctorOffDay::where('doctor_id', $doctor->id)->get();
        $dayNames = $wokringDays->pluck('day_of_week_name')->toArray();

        $offDays = [];


        foreach ($DoctoroffDays->whereNotNull('date') as $dayOff) {
            array_push(
                $offDays,
                $dayOff->date->format('Y-m-d')
            );
        }

        foreach ($DoctoroffDays->where('date', null) as $dayOff) {
            // Create a Carbon object for the start date and end date.
            $startDate = Carbon::create($dayOff->from);
            $endDate = Carbon::create($dayOff->to);

            // Create a CarbonPeriod object.
            $dateRange = CarbonPeriod::create($startDate, $endDate);

            // Iterate over the CarbonPeriod object and get the dates.
            foreach ($dateRange as $date) {
                array_push(
                    $offDays,
                    $date->format('Y-m-d')
                );
            }
        }

        return response()->json(['allowedDays' => $dayNames, 'offDays' => $offDays]);
    }

    public function getWorkingTimeByDate(Request $request)
    {
        //convert date to DayName
        //get time based on day_of_week
        $selectedDate = Carbon::parse($request->date);
        $dayName = $selectedDate->format('l');
        $dayIndex = array_search($selectedDate->format('l'), DoctorSchedule::dayNames);
        $dayTimes = DoctorSchedule::query()
            ->where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayIndex)
            ->with('serviceType')
            ->first();

        $start = Carbon::parse($request->date . ' ' . $dayTimes->from);
        $end = Carbon::parse($request->date . ' ' . $dayTimes->to);
        $periodMintues = $dayTimes->period_mintues;

        $times = [];

        // $periods = CarbonPeriod::since($start)->minutes($periodMintues)->until($end);

        $interval = CarbonInterval::minutes($periodMintues);
        $periods = new CarbonPeriod($start, $interval, $end);

        foreach ($periods as $dateTime) {
            array_push($times, $dateTime->format('H'));
        }
        $times = collect($times)->unique()->flatten(1)->toArray();
        $times = array_map('intval', $times);

        return response()->json(['times' => $times, 'stepping' => $periodMintues, 'service_type_id' => $dayTimes->serviceType->id]);
    }

    public function getWorkingDays(Request $req, Doctor $doctor)
    {

        $startDate = Carbon::parse($req->start);
        $endDate = Carbon::parse($req->end);



        //get working days for doctor
        $wokringDays = DoctorSchedule::where('doctor_id', $doctor->id)->get();
        $offDays = DoctorOffDay::where('doctor_id', $doctor->id)->get();
        $offDaysDates = $offDays->pluck('date')->toArray();


        $dayNames = $wokringDays->pluck('day_of_week_name')->toArray();
        $dates = [];
        $events = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {


            //Check working day and not in Day off Dates
            if (in_array($date->format('l'), $dayNames) && !in_array($date, $offDaysDates)) {
                // if ($date->format('l') === $dayName) {
                $dayIndex = array_search($date->format('l'), DoctorSchedule::dayNames);
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


            for ($time = $start; $time->lt($end); $time->addMinutes($periodMintues)) {
                $event = [
                    'start' => $time->toIso8601String(),
                    'end' => $time->copy()->addMinutes($periodMintues)->toIso8601String(),
                    'title' => 'Session ' . ++$counter,
                    'durationEditable' => false,
                ];
                $events[] = $event;
            }
        }

        return response()->json($events);
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

    public function create(Request $request, Doctor $doctor)
    {
        $ServiceType = Constant::where('module', Modules::DOCTOR)->where('field', DropDownFields::DOCTOR_SERVICE_TYPE)->get();
        $DayOfWeek = DoctorSchedule::dayNames;

        $createView =  view('doctors.schedule.addedit_modal', [
            'doctor' => $doctor,
            'ServiceType' => $ServiceType,
            'DayOfWeek' => $DayOfWeek
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request, doctor $doctor)
    {
        $request->validate([
            'service_type_id' => 'required',
            'day_of_week' => ['required', new UniqueDayOfWeekDoctor($doctor->id)],
            'from' => 'required',
            'to' => 'required',
            'period_mintues' => 'required',
            // 'valid_from' => 'required',
        ]);


        $newSchedule = new DoctorSchedule();
        $newSchedule->doctor_id = $doctor->id;
        $newSchedule->notes = $request->notes;
        $newSchedule->service_type_id = $request->service_type_id;
        $newSchedule->day_of_week = $request->day_of_week;
        $newSchedule->from = $request->from;
        $newSchedule->to = $request->to;
        $newSchedule->period_mintues = $request->period_mintues;
        $newSchedule->max_patients = $this->CalculateNumberOfPatients($request->from, $request->to, $request->period_mintues);
        $newSchedule->save();

        return response()->json(['status' => true, 'message' => 'Schedule has been added successfully!']);
    }


    public function edit(Request $request, DoctorSchedule $doctorSchedule)
    {
        $ServiceType = Constant::where('module', Modules::DOCTOR)->where('field', DropDownFields::DOCTOR_SERVICE_TYPE)->get();
        $DayOfWeek = DoctorSchedule::dayNames;

        $createView =  view('doctors.schedule.addedit_modal', [
            'doctor_schedule' => $doctorSchedule,
            'ServiceType' => $ServiceType,
            'DayOfWeek' => $DayOfWeek
        ])->render();
        return response()->json(['createView' => $createView]);
    }

    public function update(Request $request, DoctorSchedule $doctorSchedule)
    {
        $request->validate([
            'service_type_id' => 'required',
            'day_of_week' => 'required',
            'from' => 'required',
            'to' => 'required',
            'period_mintues' => 'required',
            // 'valid_from' => 'required',
        ]);

        $doctorSchedule->notes = $request->notes;
        $doctorSchedule->service_type_id = $request->service_type_id;
        $doctorSchedule->day_of_week = $request->day_of_week;
        $doctorSchedule->from = $request->from;
        $doctorSchedule->to = $request->to;
        $doctorSchedule->period_mintues = $request->period_mintues;
        $doctorSchedule->max_patients = $this->CalculateNumberOfPatients($request->from, $request->to, $request->period_mintues);

        $doctorSchedule->save();

        return response()->json(['status' => true, 'message' => 'Schedule has been updated successfully!']);
    }


    public function GetDoctorScheduleAppts(Request $request, Doctor $doctor)
    {
        $doctor->load(
            'speciality',
            'hospital',
            'patientClinic',
            'country',
            'city',
        );
        $showAvailableSessions = true;
        $showOffDays = true;
        if ($request->has('showAvailableSessions'))
            $showAvailableSessions = filter_var($request->showAvailableSessions, FILTER_VALIDATE_BOOLEAN);

        if ($request->has('showOffDays'))
            $showOffDays = filter_var($request->showOffDays, FILTER_VALIDATE_BOOLEAN);

        $doctorAppointments = InternalAppointment::where('doctor_id', $doctor->id)
            ->with(
                'patient',
                'patientClinic',
                'doctor',
                'speciality',
                'serviceType',
                'source'
            )
            ->whereBetween('appointment_date_start', [$request->start, $request->end])
            ->get();
        $startDate = Carbon::parse($request->start);
        $endDate = Carbon::parse($request->end);


        //get working days for doctor
        $wokringDays = DoctorSchedule::where('doctor_id', $doctor->id)->get();
        $offDays = DoctorOffDay::where('doctor_id', $doctor->id)->get();
        $offDaysDates = $offDays->pluck('date')->toArray();


        $dayNames = $wokringDays->pluck('day_of_week_name')->toArray();
        $dates = [];
        $events = [];
        $totalProcessingAppointemnts = 0;
        $totalBookedAppointemnts = 0;
        $totalCanceledAppointemnts = 0;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {


            //Check working day and not in Day off Dates
            if (in_array($date->format('l'), $dayNames) && !in_array($date, $offDaysDates)) {
                // if ($date->format('l') === $dayName) {
                $dayIndex = array_search($date->format('l'), DoctorSchedule::dayNames);
                $passed = true;

                //check Days offs in range
                foreach ($offDays->where('date', null) as $dayOff) {
                    if ($date->between($dayOff->from, $dayOff->to)) {
                        // dd('tes');
                        if ($showOffDays == true)
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
                if ($showOffDays == true) {
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
        }


        // check doctor appointments in this date range 
        //Check if it matches the internal appointment date
        //   $exists = $doctorAppointments->filter(function ($appointment) use ($time) {
        //     // dd($appointment->appointment_date_start);
        //     return $appointment->appointment_date_start->equalTo($time) ? $appointment : null;
        // });

        foreach ($doctorAppointments as $key => $doctorAppointment) {



            $appointment =  $doctorAppointment;
            $event = [
                'start' => $appointment->appointment_date_start->toIso8601String(),
                'end' =>  $appointment->appointment_date_end->toIso8601String(),

                'durationEditable' => false,
                "extendedProps" => [
                    "patient" => $appointment->patient->name_locale,
                    "patient_clinic" => $appointment->patientClinic->name_locale,
                    "speciality" => $appointment->speciality->name_locale,
                    "patient_confirm" => $appointment->patient_confirm,
                    "appointment_date_start" => $appointment->appointment_date_start->format('Y-m-d H:i:s'),
                    "appointment_date_end" => $appointment->appointment_date_end->format('Y-m-d H:i:s'),
                    "status" => $appointment->status,
                    "serviceType" => @$appointment->serviceType->name,
                    "id" => $appointment->id,
                ]
            ];

            if ($appointment->status == InternalAppointment::processing) {
                $totalProcessingAppointemnts++;
                $event = array_merge(
                    $event,
                    [
                        'title' => '🟡 - ' . $appointment->patient->name_locale,
                        'backgroundColor' => '#fff8dd',
                        'borderColor' => '#ffc700',
                        'textColor' => '#181C32',
                    ]
                );
            } else  if ($appointment->status == InternalAppointment::booked) {
                $totalBookedAppointemnts++;
                $event = array_merge(
                    $event,
                    [
                        'title' => '🟢 - ' . $appointment->patient->name_locale,
                        'backgroundColor' => '#e8fff3',
                        'borderColor' => '#50cd89',
                        'textColor' => '#181C32',
                    ]
                );
            } else  if ($appointment->status == InternalAppointment::cancelled) {
                $totalCanceledAppointemnts++;

                $event = array_merge(
                    $event,
                    [
                        'title' => '🔴 - ' . $appointment->patient->name_locale,
                        'backgroundColor' => '#fff5f8',
                        'borderColor' => '#f1416c',
                        'textColor' => '#181C32',
                    ]
                );
            }

            $events[] = $event;
        }

        // dd($events);

        $appointments = collect($events);
        $Appointmentsfiltered = $appointments->filter(function ($item) {
            return collect($item)->has('end');
        });

        foreach ($dates as $value) {
            $date = $value['date'];
            $startFrom = $wokringDays->where('day_of_week', $value['dayIndex'])->first()->from;
            $to = $wokringDays->where('day_of_week', $value['dayIndex'])->first()->to;
            $periodMintues = $value['periodMintues'];

            $start = Carbon::parse($date . ' ' . $startFrom);
            $end = Carbon::parse($date . ' ' . $to);
            $counter = 0;

            for ($time = $start; $time->lt($end); $time->addMinutes($periodMintues)) {

                if ($showAvailableSessions) {

                    $isWithinAppointmentRange = false;
                    $isEventEqualApptTimes = false;
                    $timeEnd = $time->copy()->addMinutes($periodMintues);
                    foreach ($Appointmentsfiltered as $appointment) {

                        if ($this->isTimeEventWithinAppointment($time, $timeEnd, $appointment)) {
                            $isWithinAppointmentRange = true;
                            break;
                        }
                    }

                    foreach ($Appointmentsfiltered as $appointment) {
                        if ($this->isAppointmentEqualToEvent($appointment, $timeEnd, $time)) {
                            $isEventEqualApptTimes = true;
                        }
                    }

                    if ($isWithinAppointmentRange == false && $isEventEqualApptTimes == false) {
                        $event = [
                            'start' => $time->toIso8601String(),
                            'end' => $time->copy()->addMinutes($periodMintues)->toIso8601String(),
                            'title' => 'Session ' . ++$counter,
                            'durationEditable' => false,
                            'editable' => false
                        ];
                        $events[] = $event;
                    }
                }
            }
        }
        // dd('test');

        $totalAppointments = [
            'totalProcessingAppointemnts' => $totalProcessingAppointemnts,
            'totalBookedAppointemnts' => $totalBookedAppointemnts,
            'totalCanceledAppointemnts' => $totalCanceledAppointemnts,
        ];

        return response()->json(['events' => $events, 'totalAppointments' => $totalAppointments]);
    }

    private function isTimeEventWithinAppointment($timeEventStart, $timeEventEnd, $appointment)
    {
        // $timeEventStart = Carbon::createFromFormat('H:i', $timeStart);
        // $timeEventEnd = Carbon::createFromFormat('H:i', $timeEnd);
        $appointmentStart = Carbon::parse($appointment['start']);
        $appointmentEnd = Carbon::parse($appointment['end']);


        return $timeEventStart->copy()->addMinute(1)->between($appointmentStart, $appointmentEnd)
            || $timeEventEnd->copy()->subMinute(1)->between($appointmentStart, $appointmentEnd);
    }


    private function isAppointmentEqualToEvent($appointment, $timeEventEnd, $timeEventStart)
    {
        $appointmentStart = Carbon::parse($appointment['start']);
        $appointmentEnd = Carbon::parse($appointment['end']);

        return $appointmentEnd->equalTo($timeEventEnd) && $appointmentStart->equalTo($timeEventStart);
    }


    public function scheduleWithAppointments(Request $request,  Doctor $doctor)
    {
        //If doctor doesn't have schedule enable then complain
        if ($doctor->has_schedule == false)
            return response()->json(['message' => "The selected doctor doesn't have scheduling enabled."], 400);

        $doctor->load([
            'speciality',
            'hospital',
            'patientClinic',
            'country',
            'city'
        ]);


        $calendarView = view('internalAppointments.doctor.schedule_modal', ['doctor' => $doctor])->render();
        return response()->json(['calendarView' => $calendarView]);
    }

    public function delete(Request $request, DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->delete();
        return response()->json(['status' => true, 'message' => 'Schedule Deleted Successfully !']);
    }
}
