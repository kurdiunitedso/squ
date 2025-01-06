<?php

namespace App\Http\Controllers;

use App\Models\MarketingCall;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class CallScheduleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('callschedule.calendar');
        }
        if ($request->isMethod('POST')) {
            $users = User::with('roles', 'branch')->with('roles.permissions')->with('permissions')->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            })->select('users.*');

            if (!Auth::user()->hasRole('super-admin')) {
                $users->where('id', Auth::user()->id);
            }

            return DataTables::eloquent($users)
                ->editColumn('last_login_at', function ($user) {
                    if ($user->last_login_at)
                        return $user->last_login_at->diffForHumans();
                    else return '';
                })
                ->editColumn('fullname', function ($user) {
                    $avatar  = $user->avatar != null ? asset("images/" . $user->avatar) : asset("media/avatars/blank.png");

                    $template = '
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="#">
                                            <div class="symbol-label">
                                                <img src="' . $avatar . '" alt="' . $user->name . '" class="w-100">
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary mb-1">' . $user->name . '</a>
                                        <span>' . $user->email . '</span>
                                    </div>
                                    <!--begin::User details-->
                                ';
                    return $template;
                })
                ->addColumn('action', function ($user) {
                    $showShedule = '<a href="' . route('callschedule.GetUserSchedules', ['user' => $user->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnSelectDoctor"
                    data-doctor-id="' . $user->id . '"
                    data-emp-name="' . $user->name . '"
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
                ->rawColumns(['fullname', 'action'])
                ->make();
        }
    }


    public function GetUserSchedules(Request $request, User $user)
    {
        // $doctor->load(
        //     'speciality',
        //     'hospital',
        //     'patientClinic',
        //     'country',
        //     'city',
        // );


        $userCalls = MarketingCall::where('user_id', $user->id)
            ->with(
                'patient',
                'calls',
                'callAction'
            )
            ->whereBetween('next_call_date', [$request->start, $request->end])
            ->get();

        $events = [];
        foreach ($userCalls as $key => $callSchedule) {

            $event = [
                'start' => $callSchedule->next_call_date,
                'title' => $callSchedule->patient->name_locale,
                'allDay' => true,
                "extendedProps" => [
                    'url' => route('marketing_calls.calls_action.call_action_create', ['marketingCall' => $callSchedule->id, 'patient' => $callSchedule->patient->id]),
                ]

            ];
            $events[] = $event;
        }

        return response()->json(['events' => $events]);
    }
}
