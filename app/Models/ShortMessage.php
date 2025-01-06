<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'created_at' => 'date',
    ];


    public function captin()
    {
        return $this->belongsTo(Captin::class);
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
}
