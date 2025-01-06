<?php

namespace App\Models;

use App\Http\Controllers\Calls\CallTasksCallController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallCallTask extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table ='call_call_task';
    protected $casts = [
        'next_call' => 'date',
        'created_at' => 'datetime',
    ];

    public function callTask()
    {
        return $this->belongsTo(CallTask::class)->withDefault(['name' => 'NA']);;
    }


    public function callAction()
    {
        return $this->belongsTo(Constant::class, 'call_action_id')->withDefault(['name' => 'NA']);;
    }
    public function callcdr()
    {
        return $this->belongsTo(CdrLog::class, 'call_id','uniqueid')->withDefault(['name' => 'NA']);;
    }

    public function callTaskAction()
    {
        return $this->belongsTo(Constant::class, 'callTask_action_id')->withDefault(['name' => 'NA']);;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function callOption()
    {
        return $this->belongsTo(Constant::class, 'call_option');
    }
    public function action()
    {
        //return $this->belongsTo(Constant::class, 'type');
        // return $this->morphTo(__FUNCTION__, 'action_type', 'action_id');
        return $this->morphTo();
    }


    public function callQuestionnaireResponses()
    {
        return $this->hasMany(CallQuestionnaireResponse::class,'call_id')->where('module','callTask');
    }
}
