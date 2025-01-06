<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallQuestionnaireResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'call_id',
        'captin_id',
        'module',
        'call_questionnaire_id',
        'cq_question_id',
        'answer'
    ];

    protected $with = ['questionnaire', 'question', 'captin', 'call'];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }
    public function callcall()
    {
        return $this->belongsTo(CallCallTask::class);
    }

    public function captin()
    {
        return $this->belongsTo(Captin::class);
    }

    public function questionnaire()
    {
        return $this->belongsTo(CallQuestionnaire::class, 'call_questionnaire_id');
    }

    public function question()
    {
        return $this->belongsTo(CallQuestionnaireQuestion::class, 'cq_question_id');
    }
}
