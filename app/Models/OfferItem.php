<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class OfferItem extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }



    public function items()
    {
        return $this->hasMany(Item::class, 'item_id');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id')->withDefault(['name' => 'NA']);
    }




}
