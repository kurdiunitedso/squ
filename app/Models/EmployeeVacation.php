<?php

namespace App\Models;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeVacation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'employee_vacations';

    public static function getVacationList($type = 0, $employee_id = 0, $status = 0, $department = 0, $from = 0, $to = 0)
    {
        $result = self::select('*');


        if ($type != 0) {
            $result->wherein('type', $type);
        }
        if ($employee_id != 0) {
            $result->wherein('employee_id', $employee_id);
        }
        if (!is_array($status) && $status) {
            $result->where('status', $status);
        }
        if (is_array($status)) {
            $result->wherein('status', $status);
        }
        if ($department != 0) {
            $result->wherein('deptno', $department);
        }

        if ($from && !$to) {
            $result->where('from_date', '>=', $from);

        }
        if ($to && !$from) {

            $result->where('from_date', '<=', $to);
        }

        if ($from && $to) {
            $result->where(function ($query) use ($from, $to) {
                $query->whereBetween('from_date', [$from, $to])->get();
                $query->orwhereBetween('to_date', [$from, $to])->get();
            });


        }

        return $result->wherenull('deleted_at');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function statuss()
    {
        return $this->belongsTo(Constant::class, 'status');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status');
    }

    public function types()
    {
        return $this->belongsTo(Constant::class, 'type');
    }

    public static function calculatBalance($employee, $type = 370)
    {

        $annual = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'like', '%Annual%')->get()->first();
        $sick = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'like', '%Sick%')->get()->first();
        $delivery = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'like', '%Delivery%')->get()->first();
        $approve = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'like', '%Approve%')->get()->first();
        // $reject = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name', 'Reject')->get()->first();
        $approve = isset($approve) ? $approve->id : 391;
        if ($type == (isset($sick) ? $sick->id : '0'))
            return $employee->sick;
        if ($type == (isset($delivery) ? $delivery->id : '0'))
            return 70;

        $currendate = Carbon::parse(date('Y-m-d'));
        $date = Carbon::parse(date('Y-m-d'));
        $from = $date->startOfYear()->format('Y-m-d');
        $to = $date->endOfYear()->format('Y-m-d');

        $leaves = $employee->leaves;
        $max_leaves = $employee->max_leaves;
        $max_annual_leaves = $employee->max_annual_leaves;
        $this_yearVacation = EmployeeVacation::getVacationList([$type], [$employee->id], [$approve, 1], 0, $from, $to)->sum('days');
        //return $this_yearVacation;
        $employment_date = date('Y-m-d', strtotime($employee->employment_date)) > date('Y-m-d', strtotime($from)) ? date('Y-m-d', strtotime($employee->employment_date)) : date('Y-m-d', strtotime($from));
        $days = $currendate->diffInDays(Carbon::parse($employment_date));
        // return $days;

        $balance = $leaves;
        if ($leaves < $max_leaves) {
           // $x = ($this_yearVacation - $max_annual_leaves < 0) ? 0 : ($this_yearVacation - $max_annual_leaves);
            $bonus = $leaves + ($this_yearVacation - $max_annual_leaves);;
            if ($bonus < 0) $bonus = 0;

            $balance = $days * ($max_annual_leaves / 365) - $this_yearVacation + $bonus;
        } else {
            $balance = $days * ($max_annual_leaves / 365) + $max_annual_leaves;
        }

        return $balance;

    }


}
