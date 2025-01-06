<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\HospitalClinic;
use App\Models\HospitalClinicOffDay;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HospitalCSOffDayController extends Controller
{
    public function index(Request $request, HospitalClinic $hospitalClinic)
    {
        if ($request->isMethod('POST')) {
            $hosiptalClinicScheduleDaysOff = HospitalClinicOffDay::query()
                ->where('hospital_clinic_id', $hospitalClinic->id);

            return DataTables::eloquent($hosiptalClinicScheduleDaysOff)
                ->addColumn('days_off', function ($hosiptalClinicScheduleDaysOff) {
                    $day = $hosiptalClinicScheduleDaysOff->date ? $hosiptalClinicScheduleDaysOff->date->toDateString()
                        : 'Range : ' . $hosiptalClinicScheduleDaysOff->from->toDateString() . '-' . $hosiptalClinicScheduleDaysOff->to->toDateString();
                    return $day;
                })
                ->editColumn('created_at', function ($hosiptalClinicScheduleDaysOff) {
                    return [
                        'display' => e(
                            $hosiptalClinicScheduleDaysOff->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $hosiptalClinicScheduleDaysOff->created_at->timestamp
                    ];
                })
                ->addColumn('action', function ($hosiptalClinicScheduleDaysOff) {
                    $removeBtn = '<a data-HospitalCSOffDay-name="' . $hosiptalClinicScheduleDaysOff->name_en . '" href=' . route('restaurants.clinics.daysoff.delete', ['HospitalCSOffDay' => $hosiptalClinicScheduleDaysOff->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteHospitalCSOffDay"
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
                    return  $removeBtn;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function create(Request $request, HospitalClinic $hospitalClinic)
    {
        $createView =  view('restaurants.clinics.daysoff.addedit_modal', [
            'hospitalClinic' => $hospitalClinic,
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request, HospitalClinic $hospitalClinic)
    {
        //Range Selected
        if ($request->has('rangeSwitcher')) {
            $request->validate([
                'date_range' => 'required',
                'reason' => 'required',
            ]);

            $dateRange = $request->date_range;
            $dates = explode(' to ', $dateRange);

            $fromDate = $dates[0]; // '2023-04-17'
            $toDate = $dates[1]; // '2023-04-28'

            $newHospitalClinicOffDay = new HospitalClinicOffDay();
            $newHospitalClinicOffDay->hospital_clinic_id = $hospitalClinic->id;
            $newHospitalClinicOffDay->from = $fromDate;
            $newHospitalClinicOffDay->to = $toDate;
            $newHospitalClinicOffDay->reason = $request->reason;

            $newHospitalClinicOffDay->save();
        } else {
            $request->validate([
                'date' => 'required',
                'reason' => 'required',
            ]);

            $newHospitalClinicOffDay = new HospitalClinicOffDay();
            $newHospitalClinicOffDay->hospital_clinic_id = $hospitalClinic->id;
            $newHospitalClinicOffDay->date = $request->date;
            $newHospitalClinicOffDay->reason = $request->reason;

            $newHospitalClinicOffDay->save();
        }
        return response()->json(['status' => true, 'message' => 'Day Off has been added to ' . $hospitalClinic->name . ' successfully!']);
    }


    public function delete(Request $request, $hospitalClinicOffDay)
    {

        $toBeDelete= HospitalClinicOffDay::where('id', $hospitalClinicOffDay)->first();
        $toBeDelete->delete();
        return response()->json(['status' => true, 'message' => 'Day Off Deleted Successfully !']);
    }
}
