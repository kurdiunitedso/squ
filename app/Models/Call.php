<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Call extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    protected $casts = [
        'next_call' => 'date',
        'created_at' => 'datetime',
    ];

    public function captin()
    {
        return $this->belongsTo(Captin::class);
    }

    public function callAction()
    {
        return $this->belongsTo(Constant::class, 'call_action_id')->withDefault(['name' => 'NA']);;
    }
    public function callcdr()
    {
        return $this->belongsTo(CdrLog::class, 'call_id','uniqueid');
    }

    public function captinAction()
    {
        return $this->belongsTo(Constant::class, 'captin_action_id')->withDefault(['name' => 'NA']);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault(['name' => 'NA']);
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
        return $this->hasMany(CallQuestionnaireResponse::class)->where('module','captin');
    }
}
