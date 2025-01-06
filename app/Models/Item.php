<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Item extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    protected $guarded = ['id'];
    public const ui = [
        'table' => 'items',
        'route' => 'items',

        's_ucf' => 'Item', //uppercase first
        'p_ucf' => 'Items',

        's_lcf' => 'item', //lowercase first
        'p_lcf' => 'items',

        '_id' => 'item_id',
        'controller_name' => 'ItemController',
        'image_path' => 'items',
    ];
    public function contracts()
    {
        return $this->belongsToMany(Contract::class, 'contract_items')
            ->withPivot('qty', 'cost', 'discount', 'notes')
            ->withTimestamps();
    }
}
