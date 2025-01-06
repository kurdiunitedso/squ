<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallQuestionnaireQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'call_questionnaire_id',
        'text',
    ];

    public function questionnaire()
    {
        return $this->belongsTo(CallQuestionnaire::class);
    }
}
