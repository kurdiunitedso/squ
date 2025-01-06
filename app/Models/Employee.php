<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Employee  extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];
    public const ui = [
        'table' => 'employees',
        'route' => 'employees',

        's_lcf' => 'employee', //lowercase first
        'p_lcf' => 'employees',

        '_id' => 'employee_id',
        'image_path' => 'employees',


        's_ucf' => 'Employee', //uppercase first
        'p_ucf' => 'Employees',

        'controller_name' => 'ContractController',
    ];
    public function whours()
    {
        return $this->hasMany(EmployeeWhour::class);
    }
    public function tasks_assigned()
    {
        return $this->hasMany(TaskAssignment::class, 'employee_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class)->withDefault(['name' => 'NA']);;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); //->withDefault(['name' => 'NA']);;
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status')->withDefault(['name' => 'NA']);;
    }

    public function department()
    {
        return $this->belongsTo(Constant::class, 'department_id')->withDefault(['name' => 'NA']);;
    }

    public function jobTitle()
    {
        return $this->belongsTo(Constant::class, 'job_title')->withDefault(['name' => 'NA']);;
    }

    public function gender()
    {
        return $this->belongsTo(Constant::class, 'gender')->withDefault(['name' => 'NA']);;
    }
    public function projects()
    {
        return $this->hasMany(EmployeeProject::class);;
    }
    public function bankName()
    {
        return $this->belongsTo(Constant::class, 'bank_name')->withDefault(['name' => 'NA']);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public static function canTakeVacation(Employee $employee, $vacation_type, $from_date, $to_date)
    {
        $annual = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name','like', '%Annual%')->get()->first();
        $sick = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name','like', '%Sick%')->get()->first();
        $delivery = Constant::where('module', Modules::Employee)->Where('field', DropDownFields::vacation)->where('name','like', '%Delivery%')->get()->first();


        $datetime1 = new \DateTime(date('Y-m-d', strtotime($from_date)));
        $datetime2 = new \DateTime(date('Y-m-d', strtotime($to_date)));
        $interval = $datetime1->diff($datetime2);
        if ($vacation_type == (isset($sick) ? $sick->id : 388)) {
            $days = $employee->sick - ($interval->format('%a') + 1);
        } else if ($vacation_type ==  (isset($annual) ? $annual->id : 370)) {
            $days = $employee->leaves - ($interval->format('%a') + 1);
        } else if ($vacation_type ==  (isset($delivery) ? $delivery->id : 389)) {
            $days = 70 - ($interval->format('%a') + 1);
        } else
            $days = 0;
       // $balance = EmployeeVacation::calculatBalance($employee, $vacation_type);
        $balance=$employee->balance;
        if ($interval->format('%a') + 1 > $balance) {
            $message = "No Balance Available";
            return $message;
        }
        if ($days < 0) {
            $message = "No Balance Available";
            return $message;
        }
        return 'Yes';
    }
}
