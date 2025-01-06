<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallQuestionnaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }

    public function questions()
    {
        return $this->hasMany(CallQuestionnaireQuestion::class);
    }
}
