<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCallAction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id')->withDefault(['name' => 'NA']);;
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'call_id')->withDefault(['name' => 'NA']);;
    }
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'call_id')->withDefault(['name' => 'NA']);;
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'call_id')->withDefault(['name' => 'NA']);;
    }


    public function callOption()
    {
        return $this->belongsTo(Constant::class, 'call_option_id')->withDefault(['name' => 'NA']);;
    }

    public function callcdr()
    {
        return $this->belongsTo(CdrLog::class, 'call_id','uniqueid')->withDefault(['name' => 'NA']);;
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault(['name' => 'NA']);;
    }
    public function caller()
    {
        return $this->belongsTo(Constant::class,'caller_type')->withDefault(['name' => 'NA']);;
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id')->withDefault(['name' => 'NA']);;
    }
    public function statuss()
    {
        return $this->belongsTo(Constant::class,'call_status')->withDefault(['name' => 'NA']);;
    }
    public function assign()
    {
        return $this->belongsTo(User::class,'assign_employee')->withDefault(['name' => 'NA']);;
    }
    public function urgency()
    {
        return $this->belongsTo(Constant::class,'urgency')->withDefault(['name' => 'NA']);;
    }
    public function assign_statuss()
    {
        return $this->belongsTo(Constant::class,'assign_status')->withDefault(['name' => 'NA']);;
    }

    public function action()
    {
        // return $this->morphTo(__FUNCTION__, 'action_type', 'action_id');
        return $this->morphTo();
    }
    public function callPhone2()
    {
        return $this->hasMany(CdrLog::class, 'to', 'telephone');
    }

    public function callPhone()
    {
        return $this->hasMany(CdrLog::class, 'from', 'telephone');
    }

    public function smsPhone()
    {
        return $this->hasMany(SystemSmsNotification::class, 'mobile', 'telephone');
    }

}
