<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function citys()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function categoryss()
    {
        return $this->belongsTo(Constant::class, 'clients.category')->withDefault(['name' => 'NA']);
    }

    public function statuss()
    {
        return $this->belongsTo(Constant::class, 'status')->withDefault(['name' => 'NA']);
    }




    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function callPhone2()
    {
        return $this->hasMany(CdrLog::class, 'to', 'telephone');
    }

    public function callPhone()
    {
        return $this->hasMany(CdrLog::class, 'from', 'telephone');
    }

    public function smsPhone()
    {
        return $this->hasMany(SystemSmsNotification::class, 'mobile', 'telephone');
    }

    public function visits()
    {
        return $this->morphMany(VisitRequest::class, 'visitable');
    }
    public function orders()
    {
        return $this->belongsTo(Order::class, 'client_id')->withDefault(['name' => 'NA']);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'telephone', 'telephone');
    }



}
