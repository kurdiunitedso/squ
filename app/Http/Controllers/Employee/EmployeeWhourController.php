<?php

namespace App\Http\Controllers\Employee;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\EmployeesWhourExport;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\EmployeeWhour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Invoker\Exception;

use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class EmployeeWhourController extends Controller
{
    public
    function checkOut(Request $request)
    {
        try {
            DB::beginTransaction();
            if (\Auth::user()->checkin) {
                $employee_whour = EmployeeWhour::find(\Auth::user()->checkin);
                $employee_whour->status = Constant::where('module', Modules::Employee)
                    ->where('value', '2')->get()->first()->id;
                $employee_whour->last_ip = $request->ip();
                $employee_whour->update_date = date('Y-m-d H:i:s');
                $employee_whour->update_id = \Auth::user()->id;
                $employee_whour->to_time = date('Y-m-d H:i:s');
                $employee_whour->save();
                $user = Auth::user();
                $user->checkin = null;
                $user->save();
                //$this->sendWhatsapp("972599528821", "Employee " . Auth::user()->name . "  check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                $this->sendWhatsapp("972593777700", "Employee " . Auth::user()->name . "  check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                $this->sendWhatsapp("970569099969", "Employee " . Auth::user()->name . "  check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                $this->sendWhatsapp("970592413400", "Employee " . Auth::user()->name . "  check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                //$this->sendWhatsapp("972593777700", "Employee " . Auth::user()->name . "  check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                //$this->sendWhatsapp("970592413400", "Employee " . $employee_whour->employee->name . " check in @" . $employee_whour->from_time . " and check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                DB::commit();

            } else {
                return response()->json(['status' => false, 'message' => 'Please Check In'], 401);
            }
            return response()->json(['status' => true, 'mdata' => 0, 'message' => 'Done successfully!']);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 401);
        }

    }

    function checkIn(Request $request)
    {
        try {
            DB::beginTransaction();
            if (\Auth::user()->employee->allow_outside_checkin!=1 && $request->ip() !=env('CompanyIP')) {
                return response()->json(['status' => false, 'message' => 'Please Check in for Company'], 401);
            }
            if (\Auth::user()->checkin) {
                return response()->json(['status' => false, 'message' => 'Please Check Out'], 401);
            } else {
                $employee = Employee::where('user_id', \Auth::user()->id)->get()->first();
                $employee_whour = new EmployeeWhour();
                $employee_whour->from_time = date('Y-m-d H:i:s');
                $employee_whour->create_user = \Auth::user()->id;
                $employee_whour->employee_id = $employee ? $employee->id : 0;
                $employee_whour->work_date = date('Y-m-d');
                $employee_whour->status = Constant::where('module', Modules::Employee)
                    ->where('value', '1')->get()->first()->id;
                $employee_whour->to_time = date('Y-m-d H:i:s');
                $employee_whour->last_ip = $request->ip();
                $employee_whour->update_date = date('Y-m-d H:i:s');
                $employee_whour->update_id = \Auth::user()->id;
                $employee_whour->save();
                $user = Auth::user();
                $user->checkin = $employee_whour->id;
                $user->save();

                DB::commit();
                //$this->sendWhatsapp("972599528821", "Employee " . Auth::user()->name . " check in @" . $employee_whour->from_time, 'graph', 'Tabibfind', 'Tabibfind');
                $this->sendWhatsapp("970569099969", "Employee " . Auth::user()->name . " check in @" . $employee_whour->from_time, 'graph', 'Tabibfind', 'Tabibfind');
                $this->sendWhatsapp("970592413400", "Employee " . Auth::user()->name . " check in @" . $employee_whour->from_time, 'graph', 'Tabibfind', 'Tabibfind');
                $this->sendWhatsapp("972593777700", "Employee " . Auth::user()->name . " check in @" . $employee_whour->from_time, 'graph', 'Tabibfind', 'Tabibfind');
                //$this->sendWhatsapp("972593777700", "Employee " . Auth::user()->name . "  check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');
                // $this->sendWhatsapp("970592413400", "Employee " . $employee_whour->employee->name . " check in @" . $employee_whour->from_time . " and check out @" . $employee_whour->to_time . " Total Hours: " . number_format(((strtotime($employee_whour->to_time) - strtotime($employee_whour->from_time)) / (60 * 60)), 2) . " hr", 'graph', 'Tabibfind', 'Tabibfind');

            }
            return response()->json(['status' => true, 'mdata' => $employee_whour->from_time, 'message' => 'Done successfully!']);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 401);
        }

    }

    function getCheckInOut(Request $request)
    {
        $whour = EmployeeWhour::find(\Auth::user()->checkin);
        if ($whour) {
            $time = $whour->from_time;
            return response()->json(['status' => true, 'mdata' => $time, 'message' => 'Done successfully!']);
        } else
            return response()->json(['status' => true, 'mdata' => 0, 'message' => 'Done successfully!']);
    }

    public function indexWhour(Request $request, Employee $employee)
    {
        if ($request->isMethod('GET')) {


            return view('employees.working_hours.index', [
                'employee' => $employee,
            ]);
        }
        if ($request->isMethod('POST')) {
            $whours = EmployeeWhour::with('status','user')->where('employee_id', $employee->id);
            $checkOut = Constant::where('module', Modules::Employee)
                ->where('value', '2')->get()->first()->id;

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if ($search_params['work_date'] != null) {
                    $date = explode('to', $search_params['work_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $whours->whereBetween('work_date', [$date[0], $date[1]]);
                }

            }
            $total_hours = floor(EmployeeWhour::getWhourByEmployee($employee->id, $date[0], $date[1], 0, 93)->sum(DB::raw('TIME_TO_SEC( TIMEDIFF(to_time,from_time))')) / (60 * 60));
            $whours = EmployeeWhour::with('status','user')->where('employee_id', $employee->id);
            if ($request->input('params')) {
                $search_params = $request->input('params');


                if ($search_params['work_date'] != null) {
                    $date = explode('to', $search_params['work_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $whours->whereBetween('work_date', [$date[0], $date[1]]);
                }

            }
            //return $whours->get();
            return DataTables::eloquent($whours)
                ->editColumn('created_at', function ($whour) {
                    return [
                        'display' => e(
                            $whour->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $whour->created_at->timestamp
                    ];
                })
                ->editColumn('work_date', function ($whour) {
                   return Carbon::parse( $whour->work_date)->format('l') .Carbon::parse( $whour->work_date)->format('Y-m-d');
                })
                ->editColumn('schedule', function ($d) {
                    $schhourd = 0;
                    $type='';
                    $result='';
                    if (date('H:i', strtotime($d->to_time) == "00:00"))
                        $type = 'Auto Check Out';

                    $dt = Carbon::parse($d->work_date);
                    $v = \App\Models\Holiday::isVaction($dt->format('Y-m-d'), $d->employee_id,);
                    if ($v) {
                        $type = $v;
                    }

                    $sch = \App\Models\EmployeeSwhour::getWhourByEmployeeFromSchedule($dt->format('l'), 0, 0, $d->employee_id, date('H:i', strtotime($d->from_time)), date('H:i', strtotime($d->to_time)), $dt->format('Y-m-d'));

                    if ($sch->count() > 0)
                        $j = 0;
                    $schhourd = 0;

                    foreach ($sch->get() as $s) {
                        $j++;
                        if (strtotime($s->time_to) + 60 * 60 >= strtotime($d->to_time) && strtotime($s->time_from) - 60 * 60 <= strtotime($d->from_time)) {
                            $type = 'Schedule';
                        }
                        $schhourd += (strtotime($s->time_to) - strtotime($s->time_from)) / (60 * 60);


                        $result .= (date('H:i', strtotime($s->time_from)) . "-" . date('H:i', strtotime($s->time_to)) . '<br>');
                    }
                    return $result . ' ' . $type . ' <br> Schedule Hours=' . $schhourd;

                })
                ->editColumn('to_time', function ($data) use ($request) {
                    $result = $data->to_time ;
                    $color = 'text-success';
                    if ($data->create_user != $data->update_id)
                        $color = 'text-text-danger';
                    return '<span class="' . $color . '">' . $result . '</span>';
                })
                ->setRowClass(function ($whour) use ($checkOut) {

                    return $whour->status == $checkOut ? 'table-success' : '';
                })
                ->addColumn('action', function ($whour) {
                    $editBtn = '<a href="' . route('employees.whours.edit', ['whour' => $whour->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateWhour">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $removeBtn = '<a data-whour-name="' . $whour->address . '" href=' . route('employees.whours.delete', ['whour' => $whour->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteWhour"
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
                ->editColumn('hours', function ($data) use ($request) {

                    $date = Carbon::parse($data->from_time);
                    $now =  Carbon::parse($data->to_time);

                    $diff =$now->diffInHours($date) .' hr' ;
                    return $diff;
                    //return '<span class="type">' . date_diff(date_create($data->to_time != "00:00:00" ? $data->to_time : date('Y-m-d H:i:s')), date_create(($data->from_time)))->format('%H:%I') . '</span>';
                })
                ->editColumn('hours2', function ($data) use ($request) {

                    return number_format(abs((strtotime($data->to_time != "00:00:00" ? $data->to_time : date('Y-m-d H:i:s')) - strtotime(($data->from_time))) / (60 * 60)), 1);

                })
                ->with('total_whour', $total_hours)
                ->escapeColumns([])
                ->make();
        }
    }

    public function editWhour(Request $request, EmployeeWhour $whour)
    {


        $employee = Employee::find($whour->employee_id);
        $statuss = Constant::where('module', Modules::Employee)->Wherein('value', [1, 2])->get();

        $createView = view('employees.working_hours.addedit'
            , [
                'whour' => $whour,
                'employee' => $employee,
                'statuss' => $statuss,


            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function createWhour(Request $request)
    {


        $employee = Employee::find($request->employee_id);

        $statuss = Constant::where('module', Modules::Employee)->Wherein('value', [1, 2])->get();
        $createView = view('employees.working_hours.addedit'
            , [
                'employee' => $employee,
                'statuss' => $statuss,


            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function deleteWhour(Request $request, EmployeeWhour $whour)
    {
        try {
            $whour->delete();
            return response()->json(['status' => true, 'message' => 'Employee Deleted Successfully !']);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => ' Cannot delete whour if it has employees or items  !'], 401);
        }
    }

    public function storeWhour(Request $request)
    {
        $request->validate([

            'work_date' => ['required'],


            // 'valid_from' => 'required',
        ]);
        $whour = 0;
        if ($request->whour_id)
            $whour = EmployeeWhour::find($request->whour_id);
        if ($whour)
            $whour->update($request->all());
        else
            $whour = EmployeeWhour::create($request->all());
        $whour->create_user = Auth::user()->id;
        $whour->update_id = Auth::user()->id;
        $whour->save();

        return response()->json(['status' => true, 'message' => 'Whour has been added successfully!']);
    }

    public function updateWhour(Request $request)
    {
        $request->validate([
            'work_date' => 'required',


            // 'valid_from' => 'required',
        ]);
        $whour = 0;
        if ($request->whour)
            $whour = EmployeeWhour::find($request->whour);
        if ($whour)
            $whour->update($request->all());
        else
            $whour = EmployeeWhour::create($request->all());
        $whour->update_id = Auth::user()->id;
        $whour->save();

        return response()->json(['status' => true, 'message' => 'Whour has been updated successfully!']);
    }

    function exportWhours(Request $request, $employee)
    {
        if ($request->timesheet == 1) {
            $search_params = $request->all();
            $employee = Employee::find($employee);
            $from = Carbon::now()->startOfMonth()->format('Y-m-d');
            $to = Carbon::now()->endOfMonth()->format('Y-m-d');
            if ($search_params['work_date'] != null) {
                $date = explode('to', $search_params['work_date']);
                $from = $date[0];
                $to = $date[1];
            }


            $createView = view('employees.whCalendar'
                , [
                    'from' => $from,
                    'to' => $to,
                    'employee' => $employee,
                    'title' => $employee->name . " from " . $from . " " . $to

                ])->render();
            $file = $employee->name . " from " . $from . " " . $to . ".xls";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $createView;
            return '';
        }

        return Excel::download(new EmployeesWhourExport($request->all(), $employee), 'Employees.xlsx');

    }


}
