<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortMessageCallTask extends Model
{
    use HasFactory, SoftDeletes;
protected $table='short_messages_call_tasks';
    protected $casts = [
        'created_at' => 'date',
    ];


    public function callTask()
    {
        return $this->belongsTo(CallTask::class);
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
}
