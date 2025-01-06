<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Ticket extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];
    public function cities()
    {
        return $this->belongsTo(City::class,'city_id')->withDefault(['name' => 'NA']);
    }
    public function categories()
    {
        return $this->belongsTo(Constant::class,'category')->withDefault(['name' => 'NA']);
    }

    public function statuses()
    {
        return $this->belongsTo(Constant::class,'status')->withDefault(['name' => 'NA']);
    }
    public function ticket_types()
    {
        return $this->belongsTo(Constant::class,'ticket_type')->withDefault(['name' => 'NA']);
    }
    public function purposes()
    {
        return $this->belongsTo(Constant::class,'purpose')->withDefault(['name' => 'NA']);
    }
    public function priorities()
    {
        return $this->belongsTo(Constant::class,'priority')->withDefault(['name' => 'NA']);
    }

    public function employees()
    {
        return $this->belongsTo(User::class,'employee')->withDefault(['name' => 'NA']);
    }






}
