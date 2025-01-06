<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;
    protected $guarded = ['id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withDefault(['name' => 'NA']);
    }


    public function status()
    {
        return $this->belongsTo(Constant::class, 'status')->withDefault(['name' => 'NA']);
    }


    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'NA']);
    }


}
