<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeSwhour extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'employee_schedule';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function days()
    {
        return $this->belongsTo(Constant::class, 'day_name')->withDefault(['name' => 'NA']);;
    }


    public static function getWhourByEmployeeFromSchedule($date = 0, $time_from = 0, $time_to = 0, $employee_id, $near_time_from = 0, $near_time_to = 0, $vaild_date = 0)
    {
        $result = Self::select('*')
            ->with('employee')
            ->with('days')
            ->where('employee_schedule.active', '1');;

        if ($date) {

            $result = $result->whereHas('days', function ($query) use ($date) {
                return $query->where('value', $date);
            });
        }

        if ($time_from) {
            $result = $result->where('time_from', $time_from);
        }
        if ($time_to) {
            $result = $result->where('time_to', $time_to);
        }

        $result = $result->where('employee_id', $employee_id);


        if ($near_time_from && $near_time_to) {
            $result = $result->where(function ($q) use ($near_time_from, $near_time_to) {
                $q->where(function ($qq) use ($near_time_from, $near_time_to) {
                    $qq->where('time_from', ">=", $near_time_from)->where('time_from', "<=", $near_time_to);
                    $qq->where('time_to', ">=", $near_time_from)->where('time_to', ">=", $near_time_to);
                });
                $q->orwhere(function ($qq) use ($near_time_from, $near_time_to) {
                    $qq->where('time_from', "<=", $near_time_from);
                    $qq->where('time_to', ">=", $near_time_to);

                });
                $q->orwhere(function ($qq) use ($near_time_from, $near_time_to) {
                    $qq->where('time_from', "<=", $near_time_from)->where('time_from', "<=", $near_time_to);
                    $qq->where('time_to', ">=", $near_time_from)->where('time_to', "<=", $near_time_to);

                });
                $q->orwhere(function ($qq) use ($near_time_from, $near_time_to) {
                    $qq->where('time_from', ">=", $near_time_from)->where('time_from', "<=", $near_time_to);
                    $qq->where('time_to', ">=", $near_time_from)->where('time_to', "<=", $near_time_to);

                });

            });

        }


        return $result;
    }


}
