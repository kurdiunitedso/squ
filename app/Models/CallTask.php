<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallTask extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function call()
    {
        return $this->belongsTo(ClientCallAction::class,'call_id')->withDefault(['client_name' => 'NA']);
    }
    public function task_statuss()
    {
        return $this->belongsTo(Constant::class,'task_status')->withDefault(['name' => 'NA']);
    }
    public function task_actions()
    {
        return $this->belongsTo(Constant::class,'task_action')->withDefault(['name' => 'NA']);
    }
    public function task_urgencys()
    {
        return $this->belongsTo(Constant::class,'task_urgency')->withDefault(['name' => 'NA']);
    }
    public function task_employees()
    {
        return $this->belongsTo(User::class,'task_employee')->withDefault(['name' => 'NA']);
    }
    public function calls()
    {
        return $this->hasMany(CallCallTask::class,'callTask_id','id');
    }
    public function smss()
    {
        return $this->hasMany(ShortMessageCallTask::class,'callTask_id','id');
    }


}
