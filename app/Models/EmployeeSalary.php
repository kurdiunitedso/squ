<?php

namespace App\Models;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use Database\Seeders\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trig\Cosecant;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'salary';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function statuss()
    {
        return $this->belongsTo(Constant::class, 'status');
    }
    public function months()
    {
        return $this->belongsTo(Constant::class, 'month');
    }
    public function years()
    {
        return $this->belongsTo(Constant::class, 'year');
    }
    public function types()
    {
        return $this->belongsTo(Constant::class, 'type');
    }
    public function payment_roll()
    {
        return $this->hasMany(PaymentRollSalary::class, 'salary_id');
    }


    public static function getSalary($employee_id = 0, $type = 0, $month = 0, $year = 0, $status = 0, $project = 0, $order = 0)
    {

        if ($order)
            $result = self::select('employee_name','bank_iban','employee_no','department','month','year','total_salary','allowance','deduction','salary.*', DB::raw('(select type from optimum_types where id=salary.type) as s_type'))->where('salary.active', '1');
        else
            $result = self::select('salary.*', 'salary.id as eid', DB::raw('(select type from optimum_types where id=salary.type) as s_type'))
                ->where('salary.active', '1');

        if ($employee_id) {
            $result = $result->where('employee_id', $employee_id);
        }

        if ($type) {
            $result = $result->where('salary.type', $type);
        }
        if ($status) {
            $result = $result->where('salary.status', $status);
        }
        if ($month) {
            $result = $result->where('salary.month', $month);
        }
        if ($year) {
            $result = $result->where('salary.year', $year);
        }
        if ($project) {
            $result = $result->wherein('salary.id', PaymentRollSalary::where('payment_type', $project)->pluck('salary_id')->toArray());
        }

        return $result;
    }

    public static function getSalary2($employee_id = 0, $type = 0, $month = 0, $year = 0, $status = 0, $project = 0)
    {
        $result = self::select('salary.*', 'salary.id as eid', DB::raw('(select type from optimum_types where id=salary.type) as s_type'))
            ->where('salary.active', '1');

        if (is_array($employee_id) && !in_array(0, $employee_id)) {
            $result = $result->wherein('employee_id', $employee_id);
        }
        if (!is_array($employee_id) && $employee_id) {
            $result = $result->where('employee_id', $employee_id);
        }
        if ($type) {
            $result = $result->where('salary.type', $type);
        }
        if ($status) {
            $result = $result->where('salary.status', $status);
        }
        if ($month) {
            $result = $result->where('salary.month', $month);
        }
        if ($year) {
            $result = $result->where('salary.year', $year);
        }
        if ($project) {
            $result = $result->wherein('salary.id', EmployeePayment_Roll::where('payment_type', $project)->pluck('salary_id')->toArray());
        }

        return $result;
    }

    public static function getSalary3($employee_id = 0, $type = 0, $month = 0, $year = 0, $status = 0, $project = 0)
    {
        $deduction_type = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::payment_roll_category)->where('name', 'deduction')->get()->first();
        $allowance_type=Constant::where('module', Modules::Employee)->Where('field', DropDownFields::payment_roll_category)->where('name', 'deduction')->get()->first();
        $hour_rate_type= Constant::where('module', Modules::Employee)->Where('field', DropDownFields::payment_roll)->where('name', 'hour_rate')->get()->first();

        $result = self::where('salary.active', '1');

        if (is_array($employee_id) && !in_array(0, $employee_id)) {
            $result = $result->wherein('employee_id', $employee_id);
        }
        if (!is_array($employee_id) && $employee_id) {
            $result = $result->where('employee_id', $employee_id);
        }
        if ($type) {
            $result = $result->where('salary.type', $type);
        }
        if ($status) {
            $result = $result->where('salary.status', $status);
        }
        if ($month) {
            $result = $result->where('salary.month', $month);
        }
        if ($year) {
            $result = $result->where('salary.year', $year);
        }
        if ($project) {
            $result = $result->wherein('salary.id', PaymentRollSalary::where('payment_type', $project)->pluck('salary_id')->toArray());

        }
        $allowance = PaymentRollSalary::wherein('salary_id', $result->pluck('id')->toArray())->where('category', '<>', $allowance_type?$allowance_type->id:0)->where('active',1)->sum('amount');
        $ded = PaymentRollSalary::wherein('salary_id', $result->pluck('id')->toArray())->where('category', $allowance_type?$allowance_type->id:0)->where('active',1)->sum('amount');
        return $allowance - $ded;
    }

}
