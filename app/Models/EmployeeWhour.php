<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeWhour extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'update_id');
    }
    public function statuss()
    {
        return $this->belongsTo(Constant::class, 'status');
    }

    /* public static function getWhourByEmployee( $status = 0)
     {
         $result = self::with('status')->with('employee');

         if ($status)
             $result = $result->where("employee_whourss.status", $status);



         return $result->wherein('employee_whourss.id',User::pluck('checkin')->toArray())
             ->orwhere(function ($q){$q->where('from_time','>=',date('Y-m-d'). " 00:00:00")->where('from_time','<',date('Y-m-d H:i:s'));});
     }*/
    public static function getWhourByEmployee($id = 0, $from = 0, $to = 0, $name = 0, $status = 0)
    {
        $result = self::select('employee_whours.*')
            ->with('employee')
            ->with('user')->with('statuss')
            ->where('employee_whours.active', '1')
            ->wherenull('employee_whours.deleted_at');

        if ($id)
            $result = $result->where('employee_whours.employee_id', $id);
        if ($from)
            $result = $result->where(DB::raw("(CAST(work_date as Date))"), ">=", $from);
        if ($to)
            $result = $result->where(DB::raw("(CAST(work_date as Date))"), "<", $to);
        if ($status)
            $result = $result->where("employee_whours.status", $status);
        if ($name)
            $result = $result->whereHas('employee', function ($query) use ($name) {
                return $query->where('name', 'like', "%" . $name . "%");
            });


        return $result;
    }


}
