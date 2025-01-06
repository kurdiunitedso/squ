<?php

namespace App\Http\Controllers\Vacations;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\MyVacationsExport;
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

class MyVacationController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $employee=Employee::where('user_id',Auth::user()->id)->get()->first();
            $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->get();
            $status = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation_status)->get();
            return view('myvacations.index', [
                'types' => $types
                ,    'employee' => $employee
                , 'statuss' => $status
            ]);
        }
        if ($request->isMethod('POST')) {
            $employee=Employee::where('user_id',Auth::user()->id)->get()->first();
            if(!isset($employee))
                return response()->json(['message' => 'error'],400);
            $vacations = EmployeeVacation::with('statuss', 'types', 'employees')->where('employee_id',$employee->id);
            $approve = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation_status)->where('name', 'Approve')->get()->first();
            $approve_id = isset($approve) ? $approve->id : 1;
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
                ->addColumn('action', function ($vacation) use ($approve_id) {
                    $editBtn = '<a href="' . route('myvacations.edit', ['vacation' => $vacation->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateVacation">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';

                    if ($vacation->status != $approve_id)
                        return $editBtn;
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
        if(Auth::user()->id!=$employee->user_id)
            return response()->json(['message' => 'error'],400);
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->get();
        $employees = Employee::all();
        $createView = view('myvacations.addedit'
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


        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->get();
        $employee=Employee::where('user_id',Auth::user()->id)->get()->first();
        $createView = view('myvacations.addedit'
            , [
                'employee' => $employee,
                'types' => $types,


            ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function Vacation(Request $request, $Id = null)
    {
        //return $request->all();
        $employee = Employee::find($request->employee_id);
        if(Auth::user()->id!=$employee->user_id)
            return response()->json(['message' => 'error'],400);
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
            return redirect()->route('myvacations.index', [
                'Id' => $newVacation->id,
                //'vacation' => $newVacation->id
            ])
                ->with('status', $message);
    }


    public function export(Request $request)
    {

        return Excel::download(new MyVacationsExport($request->all()), 'myvacations.xlsx');
    }

}




