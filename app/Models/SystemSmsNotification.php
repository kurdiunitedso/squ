<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSmsNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
}
