<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Restaurant extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];

    public function branches()
    {
        return $this->hasMany(RestaurantBranch::class);
    }
    public function items()
    {
        return $this->hasMany(RestaurantItem::class);
    }

    public function employees()
    {
        return $this->hasMany(RestaurantEmployee::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id')->withDefault(['name' => 'NA']);;
    }
    public function cities()
    {
        return $this->belongsTo(City::class,'city_id')->withDefault(['name' => 'NA']);;
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id')->withDefault(['name' => 'NA']);;
    }
    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id')->withDefault(['name' => 'NA']);;
    }
    public function types()
    {
        return $this->belongsTo(Constant::class, 'type_id')->withDefault(['name' => 'NA']);;
    }
    public function posType()
    {
        return $this->belongsTo(Constant::class, 'pos_type')->withDefault(['name' => 'NA']);;
    }
    public function posTypes()
    {
        return $this->belongsTo(Constant::class, 'pos_type')->withDefault(['name' => 'NA']);;
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function callPhone()
    {
        return $this->hasMany(CdrLog::class,'from','telephone');
    }
    public function callPhone2()
    {
        return $this->hasMany(CdrLog::class,'to','telephone');
    }
    public function smsPhone()
    {
        return $this->hasMany(SystemSmsNotification::class,'mobile','telephone');
    }

    /*public function visits()
    {
        return $this->hasMany(Visit::class,'telephone','telephone');
    }*/
    public function visits()
    {
        return $this->morphMany(VisitRequest::class, 'visitable');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class,'telephone','telephone');
    }

}
