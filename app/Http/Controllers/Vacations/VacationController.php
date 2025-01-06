<?php

namespace App\Http\Controllers\Vacations;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\VacationsExport;
use App\Http\Controllers\Controller;
use App\Models\Captin;
use App\Models\Employee;
use App\Models\EmployeeVacation;
use App\Models\Vacation;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\Constant;

use App\Models\Restaurant;
use App\Models\SystemSmsNotification;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VacationController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            $employees = User::all();

            $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->get();
            $status = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation_status)->get();
            return view('vacations.index', [
                'types' => $types
                , 'statuss' => $status
                , 'employees' => $employees
            ]);
        }
        if ($request->isMethod('POST')) {
            $vacations = EmployeeVacation::with('statuss', 'types', 'employees');
            $approve = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation_status)->where('name', 'Approve')->get()->first();
            $approve_id=isset($approve)?$approve->id:1;
            //return  $vacations->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if ($search_params['from_date'] != null) {
                    $date = explode('to', $search_params['from_date']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $vacations->whereBetween('from_date', [$date[0], $date[1]]);
                }

                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $vacations->whereIn('status', $results);

                }
                if (array_key_exists('type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type']);
                    if (count($results) > 0)
                        $vacations->whereIn('type', $results);

                }
                if (array_key_exists('employee_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['employee_id']);
                    if (count($results) > 0)
                        $vacations->whereIn('employee_id', $results);

                }

            }

            //return $vacations->get();
            return DataTables::eloquent($vacations)
                ->addColumn('action', function ($vacation) {
                    $editBtn = '<a href="' . route('vacations.edit', ['vacation' => $vacation->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateVacation">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    $removeBtn = '<a data-vacation-name="' . $vacation->address . '" href=' . route('vacations.delete', ['vacation' => $vacation->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteVacation"
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
                ->setRowClass(function ($vacation) use ($approve_id) {

                    return $vacation->status == $approve_id ? 'table-success' : '';
                })
                ->escapeColumns([])
                ->make();
        }
    }

    public function edit(Request $request, EmployeeVacation $vacation)
    {


        $employee = Employee::find($vacation->employee_id);
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->get();
        $employees = Employee::all();
        $createView = view('vacations.addedit'
            , [
                'vacation' => $vacation,
                'employee' => $employee,
                'employees' => $employees,
                'types' => $types,


            ])->render();
        return response()->json(['createView' => $createView]);
    }

    public function create(Request $request)
    {


        $employees = Employee::all();

        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->get();
        $createView = view('vacations.addedit'
            , [
                'employees' => $employees,
                'types' => $types,


            ])->render();
        return response()->json(['createView' => $createView]);
    }

    public function delete(Request $request, EmployeeVacation $vacation)
    {
        try {
            $vacation->delete();
            return response()->json(['status' => true, 'message' => 'Employee Deleted Successfully !']);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => ' Cannot delete vacation if it has employees or items  !'], 401);
        }
    }

    public function Vacation(Request $request, $Id = null)
    {
        //return $request->all();
        $request->validate([
            'employee_id' => 'required',

        ]);
        $employee = Employee::find($request->employee_id);
        $canTakeVacation = Employee::canTakeVacation($employee, $request->type, $request->from_date, $request->to_date);
        if (isset($Id)) {
            $newVacation = EmployeeVacation::find($Id);
            if ($canTakeVacation != "Yes")
                return response()->json(['status' => false, 'message' => $canTakeVacation], 400);
            $newVacation->update($request->all());

        } else {
            if ($canTakeVacation != "Yes")
                return response()->json(['status' => false, 'message' => $canTakeVacation], 400);
            $newVacation = EmployeeVacation::create($request->all());

        }
        $datetime1 = new \DateTime(date('Y-m-d', strtotime($request->from_date)));
        $datetime2 = new \DateTime(date('Y-m-d', strtotime($request->to_date)));
        $interval = $datetime1->diff($datetime2);
        $newVacation->days = $interval->format('%a') + 1;
        $newVacation->balance = EmployeeVacation::calculatBalance($employee);
        $newVacation->save();
        //$employee->balance= EmployeeVacation::calculatBalance($employee);
        $employee->save();

        $message = 'Vacation has been added successfully!';
        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Vacation has been added successfully!']);
        else
            return redirect()->route('vacations.index', [
                'Id' => $newVacation->id,
                //'vacation' => $newVacation->id
            ])
                ->with('status', $message);
    }

    public function approve(Request $request)
    {
        try {
            $annual = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'Annula')->get()->first();
            $sick = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'Sick')->get()->first();
            $delivery = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'Delivery')->get()->first();
            $approve = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation_status)->where('name', 'Approve')->get()->first();
            $reject = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation_status)->where('name', 'Reject')->get()->first();

            if ($request->selectedVacations) {
                $selectedVacations = explode(',', $request->selectedVacations);
                $count = count($selectedVacations);
                if ($request->approve == 1) {
                    foreach ($selectedVacations as $k => $v) {
                        $vacation = EmployeeVacation::find($v);
                        $employee = Employee::find($vacation->employee_id);

                        if (!$employee)
                            return response(["status" => false, "message" => "Error in Employee"], 400);
                        $balance = EmployeeVacation::calculatBalance($employee);
                        if ($vacation->days > $balance) {
                            $message = "No Balance Available";
                            $status = "error";
                            return response(["status" => false, "message" => $message], 400);
                        }
                        if ($vacation->type == (isset($sick) ? $sick->id : '0')) {
                            $days = $employee->sick - $vacation->days;
                            $employee->sick = $days;
                        }
                        if ($vacation->type == (isset($annual) ? $annual->id : '0')) {
                            $days = $employee->leaves - $vacation->days;
                            $employee->leaves = $days;
                        }
                        $vacation->status = (isset($approve) ? $approve->id : '1');
                        $vacation->leaves = $balance;
                        $vacation->save();
                        $employee->balance = $balance;
                        $employee->save();
                    }
                } else {
                    foreach ($selectedVacations as $k => $v) {
                        $vacation = EmployeeVacation::find($v);
                        if ($vacation->status != (isset($approve) ? $approve->id : '1')) {
                            $vacation->status = (isset($reject) ? $reject->id : '0');
                            $vacation->save();
                        }

                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Vacation Status Changed  Successfully !']);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 401);
        }

    }

    public function export(Request $request)
    {

        return Excel::download(new VacationsExport($request->all()), 'vacations.xlsx');
    }

}




