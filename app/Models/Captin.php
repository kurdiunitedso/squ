<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Captin extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'assign_city_id');
    }

    public function shifts()
    {
        return $this->belongsTo(Constant::class, 'shift')->withDefault(['name' => 'NA']);
    }

    public function vehicle()
    {
        return $this->belongsTo(Constant::class, 'vehicle_type')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }

    /* public function vehicle_model()
     {
         return $this->belongsTo(Constant::class, 'vehicle_model')->where('module','captin_module')->withDefault(['name' => 'NA']);
     }*/
    public function bankName()
    {
        return $this->belongsTo(Constant::class, 'bank_name')->where('module', 'restaurant_module')->withDefault(['name' => 'NA']);
    }
    public function insuranceCompany()
    {
        return $this->belongsTo(Constant::class, 'insurance_company')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }
    public function orders()
    {
        return $this->belongsTo(Order::class, 'captin_id')->withDefault(['name' => 'NA']);
    }

    public function payment_types()
    {
        return $this->belongsTo(Constant::class, 'payment_type')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }

    public function payment_methods()
    {
        return $this->belongsTo(Constant::class, 'payment_method')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function visits()
    {
        return $this->morphMany(VisitRequest::class, 'visitable');
    }
    public function calls()
    {
        return $this->hasMany(Call::class, 'captin_id', 'id');
    }

    public function smss()
    {
        return $this->hasMany(ShortMessage::class, 'captin_id', 'id');
    }

    public function callPhone2()
    {
        return $this->hasMany(CdrLog::class, 'to', 'mobile1');
    }

    public function callPhone()
    {
        return $this->hasMany(CdrLog::class, 'from', 'mobile1');
    }

    public function smsPhone()
    {
        return $this->hasMany(SystemSmsNotification::class, 'mobile', 'mobile1');
    }

    /*  public function visits()
    {
        return $this->hasMany(Visit::class, 'telephone', 'mobile1');
    }*/

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'telephone', 'mobile1');
    }
}
