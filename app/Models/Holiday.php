<?php

namespace App\Models;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use Database\Seeders\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trig\Cosecant;

class Holiday extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'holidays';

    public static function isVaction($date, $employee_id = 0)
    {
        $vacation = 0;
        $from = date("Y-m-d");
        $interval = \DateInterval::createFromDateString('1 day');
        $to = date("Y-m-d", strtotime($date) + 60 * 24 * 60);


        $result = self::where('from_date', "<=", $date)->where('to_date', ">=", $date)->where('active', 1)->get()->first();
        if ($result)
            $vacation =  /*TypesModel::getTypeName($result->type)?TypesModel::getTypeName($result->type):*/
                "Holiday";
        else {

            $result = EmployeeVacation::where('employee_id', $employee_id)->where('from_date', "<=", $date)->where('to_date', ">=", $date)->where('status', 391)->where('active', 1)->get()->first();
            if ($result)
                $vacation = /*TypesModel::getTypeName($result->type)?TypesModel::getTypeName($result->type):*/
                    "Vacation";
        }

        return $vacation;

    }
}
