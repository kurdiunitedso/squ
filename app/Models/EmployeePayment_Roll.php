<?php

namespace App\Models;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use Database\Seeders\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trig\Cosecant;

class EmployeePayment_Roll extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'payment_roll';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function currencys()
    {
        return $this->belongsTo(Constant::class, 'currency')->withDefault(['name' => 'NA']);
    }
    public function status()
    {
        return $this->belongsTo(Constant::class, 'status');
    }

    public function types()
    {
        return $this->belongsTo(Constant::class, 'type');
    }

    public function categorys()
    {
        return $this->belongsTo(Constant::class, 'category');
    }

    public static function getPaymentRollSalary($employee_id, $type = 0)
    {
        $deduction_type=Constant::where('module', Modules::Employee)->Where('field', DropDownFields::payment_roll_category)->where('name', 'deduction')->get()->first();
        $allowance_type=Constant::where('module', Modules::Employee)->Where('field', DropDownFields::payment_roll_category)->where('name', 'deduction')->get()->first();
        $hour_rate_type= Constant::where('module', Modules::Employee)->Where('field', DropDownFields::payment_roll)->where('name', 'hour_rate')->get()->first();
        if($deduction_type)
        $deduction = Self::where('employee_id', $employee_id)->where('payment_roll.active', '1')->where('category', $deduction_type->id)->sum('amount');
        else
            $deduction=0;
        if($allowance_type)
        $allowance = Self::where('employee_id', $employee_id)->where('payment_roll.active', '1')->where('category', '<>', $allowance_type->id)->sum('amount');
        else
            $allowance=0;
        if($hour_rate_type)
        $hour_rate = Self::where('employee_id', $employee_id)->where('payment_roll.active', '1')->where('type',$hour_rate_type->id)->sum('amount');
        else
            $hour_rate=0;

        $result = '';
        if ($type == 0)
            return $allowance- $deduction;
        if ($type == 1)
            return $allowance;;
        if ($type == 2)
            return $deduction;;
        if ($type == 3)
            return $hour_rate;
        if ($type == 11) {
            foreach (Self::where('employee_id', $employee_id)->where('payment_roll.active', '1')->where('category', '<>', $allowance_type->id)->get() as $a) {
                $result .= "Project:" . (Constant::find($a->payment_type) ? Constant::find($a->payment_type)->name : '') . " " . (Constant::find($a->type) ? Constant::find($a->type)->name : '') . ":" . number_format($a->amount, 2) . " NIS";
                $result .= ".<br>   ";
            }
            return $result;
        }
        if ($type == 22) {
            foreach (Self::where('employee_id', $employee_id)->where('payment_roll.active', '1')->where('category', $deduction_type->id)->get() as $a) {
                $result .= (Constant::find($a->type) ? Constant::find($a->type)->name : '') . ": -" . number_format($a->amount, 2) . " NIS";
                $result .= ".<br>   ";
            }
            return $result;
        }
        return 0;


    }
}
