<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class Claim extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo(ClientTrillion::class, 'client_id');
    }

    public function items()
    {
        return $this->hasMany(ClaimItem::class, 'claim_id');
    }



    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id')->withDefault(['name' => 'NA']);
    }
    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id')->withDefault(['name' => 'NA']);
    }
    public function currencys()
    {
        return $this->belongsTo(Constant::class, 'currency')->withDefault(['name' => 'NA']);
    }

}
