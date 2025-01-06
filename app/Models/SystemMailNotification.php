<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use mysql_xdevapi\Table;

class SystemMailNotification extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $table='system_mail_notifications';

    public function sender()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }
}
