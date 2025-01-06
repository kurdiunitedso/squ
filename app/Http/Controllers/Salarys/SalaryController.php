<?php

namespace App\Http\Controllers\Salarys;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\SalarysExport;
use App\Http\Controllers\Controller;
use App\Models\CdrLog;
use App\Models\Employee;
use App\Models\EmployeePayment_Roll;
use App\Models\EmployeeSalary;
use App\Models\Constant;
use App\Models\EmployeeSwhour;
use App\Models\EmployeeWhour;
use App\Models\Holiday;
use App\Models\PaymentRollSalary;
use App\Models\SystemSmsNotification;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {

            $employees = User::all();

            $status = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary_status)->get();
            $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary)->get();
            $months = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::Month)->get();
            $years = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::Year)->get();

            return view('salarys.index', [
                'types' => $types,
                'statuss' => $status,
                'months' => $months,
                'years' => $years,
                'employees' => $employees
            ]);
        }
        if ($request->isMethod('POST')) {
            $salarys = EmployeeSalary::with('statuss', 'months', 'years', 'types', 'employee');
            $approve = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary_status)->where('name', 'Approve')->get()->first();
            $approve_id = isset($approve) ? $approve->id : 1;
            //return  $salarys->get();

            if ($request->input('params')) {
                $search_params = $request->input('params');


                if ($search_params['created_at'] != null) {
                    $date = explode('to', $search_params['created_at']);
                    if (count($date) == 1) $date[1] = $date[0];
                    $salarys->whereBetween('created_at', [$date[0], $date[1]]);
                }

                if (array_key_exists('status', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['status']);
                    if (count($results) > 0)
                        $salarys->whereIn('status', $results);
                }
                if (array_key_exists('type', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['type']);
                    if (count($results) > 0)
                        $salarys->whereIn('type', $results);
                }
                if (array_key_exists('month', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['month']);
                    if (count($results) > 0)
                        $salarys->whereIn('month', $results);
                }
                if (array_key_exists('year', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['year']);
                    if (count($results) > 0)
                        $salarys->whereIn('year', $results);
                }

                if (array_key_exists('employee_id', $search_params)) {
                    $results = $this->filterArrayForNullValues($search_params['employee_id']);
                    if (count($results) > 0)
                        $salarys->whereIn('employee_id', $results);
                }
            }

            //return $salarys->get();
            return DataTables::eloquent($salarys)
                ->editColumn('working_hours', function ($salary) {
                    return '<a href="' . route('salarys.whour_report', ['salary' => $salary->id]) . '"  class="ShowWhourReport" size="lg" data-kt-whour-table-actions="show_whour">'
                        . $salary->working_hours .
                        '</a>';
                    // return $ticket->telephone;
                })
                ->addColumn('action', function ($salary) {
                    $editBtn = '<a href="' . route('salarys.edit', ['salary' => $salary->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateSalary">
                    <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                    </svg>
                    </span>
                    </a>';
                    $excel = '<a href="' . route('salarys.whour_report', ['salary' => $salary->id]) . '?print=xls" target="_blank" class="btn btn-icon btn-active-light-primary w-30px h-30px">
                    <span class="svg-icon svg-icon-3">
                    <i class="fa fa-file-excel"></i>
                    </span>
                    </a>';
                    $removeBtn = '<a data-salary-name="' . $salary->address . '" href=' . route('salarys.delete', ['salary' => $salary->id]) . ' class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteSalary"
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
                    return $editBtn . $removeBtn . $excel;
                })
                ->setRowClass(function ($salary) use ($approve_id) {

                    return $salary->status == $approve_id ? 'table-success' : '';
                })
                ->escapeColumns([])
                ->make();
        }
    }

    public function edit(Request $request, EmployeeSalary $salary)
    {


        $employee = Employee::find($salary->employee_id);
        $employees = Employee::all();
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary)->get();
        $months = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::Month)->get();
        $years = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::Year)->get();
        $createView = view(
            'salarys.addedit',
            [
                'salary' => $salary,
                'employee' => $employee,
                'employees' => $employees,
                'types' => $types,
                'months' => $months,
                'years' => $years,

            ]
        )->render();
        return response()->json(['createView' => $createView]);
    }

    public function create(Request $request)
    {


        $employees = Employee::all();
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary)->get();
        $months = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::Month)->get();
        $years = Constant::where('module', Modules::main_module)->Where('field', DropDownFields::Year)->get();
        $types = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary)->get();
        $createView = view(
            'salarys.addedit',
            [
                'employees' => $employees,
                'types' => $types,
                'types' => $types,
                'months' => $months,
                'years' => $years,


            ]
        )->render();
        return response()->json(['createView' => $createView]);
    }

    public function delete(Request $request, EmployeeSalary $salary)
    {
        try {
            $salary->delete();
            return response()->json(['status' => true, 'message' => 'Employee Deleted Successfully !']);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => ' Cannot delete salary if it has employees or items  !'], 401);
        }
    }

    public function Salary(Request $request, $Id = null)
    {
        try {
            //return $request->all();
            $request->validate([
                'employee_id' => 'required',

            ]);



            if (isset($Id)) {
                $employee_salary = EmployeeSalary::find($Id);

                $employee_salary->update($request->all());
            } else {
                $count = EmployeeSalary::getSalary($request->employee_id, $request->type, $request->month, $request->year)->count();
                if ($count) {
                    return response(["status" => false, "message" => "Duplicated Salary"], 401);
                }
                $employee_salary = EmployeeSalary::create($request->all());
            }


            $from = Constant::find($employee_salary->year)->value . "-" . Constant::find($employee_salary->month)->value . "-01";
            $to = Carbon::parse($from)->endOfMonth()->format('Y-m-d');

            $employee = Employee::find($employee_salary->employee_id);
            $employee_salary->total_salary = EmployeePayment_Roll::getPaymentRollSalary($employee_salary->employee_id, 0);
            $employee_salary->allowance = EmployeePayment_Roll::getPaymentRollSalary($employee_salary->employee_id, 11);
            $employee_salary->deduction = EmployeePayment_Roll::getPaymentRollSalary($employee_salary->employee_id, 22);
            $employee_salary->total_allowance = EmployeePayment_Roll::getPaymentRollSalary($employee_salary->employee_id, 1);
            $employee_salary->total_deduction = EmployeePayment_Roll::getPaymentRollSalary($employee_salary->employee_id, 2);
            $employee_salary->hour_rate = EmployeePayment_Roll::getPaymentRollSalary($employee_salary->employee_id, 3);
            $employee_salary->employee_name = Employee::find($employee_salary->employee_id)->name;
            $employee_salary->bank_iban = $employee->bank_iban;
            $employee_salary->employee_no = $employee->empno;
            $employee_salary->department = 0;

            $begin = new \DateTime($from);
            $end = new \DateTime($to);

            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end->add($interval));
            $total_hours = 0;
            $employee_salary->working_hours = EmployeeWhour::getWhourByEmployee($employee_salary->employee_id, $from, $end->format('Y-m-d'), 0, 93)
                ->sum(DB::raw('TIME_TO_SEC( TIMEDIFF(to_time,from_time))')) / (60 * 60);

            $total_sch = 0;
            foreach ($period as $dt) {
                $v = Holiday::isVaction($dt->format('Y-m-d'), $employee->id);
                if ($v)
                    continue;
                $schhourd = 0;
                $sch = EmployeeSwhour::getWhourByEmployeeFromSchedule($dt->format('l'), 0, 0, $employee->id, 0, 0, $dt->format('Y-m-d'));

                foreach ($sch->get() as $s) {
                    $schhourd += (strtotime($s->time_to) - strtotime($s->time_from)) / (60 * 60);
                }
                $total_sch += $schhourd;
            }

            $employee_salary->schedule_hours = $total_sch;
            $employee_salary->save();
            PaymentRollSalary::where('salary_id', $employee_salary->id)->delete();
            foreach (EmployeePayment_Roll::where('employee_id', $employee->id)->get() as $p) {
                $prs = PaymentRollSalary::create($p->toArray());
                $prs->salary_id = $employee_salary->id;
                $prs->save();
            }

            $message = 'Salary has been added successfully!';


            $month = $employee_salary->months->name;
            $year = $employee_salary->years->name;
            $employee = $employee_salary->employee->name;
            $subject = "Salary for $employee Notification";
            $content = "Salary For month $month @ $year is generated for employee $employee<br> Please process action https://wheels.developon.co/salarys Click Here<</a>";
            $data = ["content" => $content];
            $cc = ['mkurdi@developon.co'];
            $to = ['mkurdi@developon.co'];
            $mobile = $this->refineMobile('0599528821', '972');

            $this->LogNotification('Salary', $employee_salary->id, 1, $data, Auth::user()->id, $subject, [], $to, 'wheels@developon.co', $cc);
            $this->sendSuperSMS('TabibFind', $mobile, $content, 'Salary', $employee_salary->id, 0);
            $this->sendWhatsapp($mobile, $content);
            $message = "Done";
            $status = "success";
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $ex->getMessage(), $ex->getCode()]);
        }

        if ($request->ajax())
            return response()->json(['status' => true, 'message' => 'Salary has been added successfully!']);
        else
            return redirect()->route('salarys.index', [
                'Id' => $employee_salary->id,
                //'salary' => $newSalary->id
            ])
                ->with('status', $message);
    }

    public function approve(Request $request)
    {
        try {

            $approve = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary_status)->where('name', 'Approve')->get()->first();
            $reject = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::salary_status)->where('name', 'Reject')->get()->first();

            if ($request->selectedSalarys) {
                $selectedSalarys = explode(',', $request->selectedSalarys);
                $count = count($selectedSalarys);
                if ($request->approve == 1) {
                    foreach ($selectedSalarys as $k => $v) {
                        $salary = EmployeeSalary::find($v);
                        $employee = Employee::find($salary->employee_id);

                        if (!$employee)
                            return response(["status" => false, "message" => "Error in Employee"], 400);


                        $salary->status = (isset($approve) ? $approve->id : '1');
                        $salary->save();
                    }
                } else {
                    foreach ($selectedSalarys as $k => $v) {
                        $salary = EmployeeSalary::find($v);
                        if ($salary->status != (isset($approve) ? $approve->id : '1')) {
                            $salary->status = (isset($reject) ? $reject->id : '0');
                            $salary->save();
                        }
                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Salary Status Changed  Successfully !']);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 401);
        }
    }


    public function export(Request $request)
    {

        return Excel::download(new SalarysExport($request->all()), 'salarys.xlsx');
    }

    public function showWhourReport(Request $request, EmployeeSalary $salary)
    {
        $from = Constant::find($salary->year)->value . '-' . Constant::find($salary->month)->value . '-' . '01';
        $fromm = Carbon::parse($from);

        $to = $request->to ? $request->to : $fromm->endOfMonth()->format('Y-m-d');
        $employee = Employee::find($salary->employee_id);

        $createView = view(
            'salarys.whCalendar',
            [
                'from' => $from,
                'fromm' => $fromm,
                'to' => $to,
                'employee' => $employee,
                'salary' => $salary,

            ]
        )->render();
        if ($request->print) {
            $file = $employee->name . " from " . $fromm . " " . $to . ".xls";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $createView;
            return '';
        }
        return response()->json(['createView' => $createView]);
    }
}
