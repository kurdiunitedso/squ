<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Lead extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    // protected $guarded = ['id'];
    public const ui = [
        'table' => 'leads',
        'route' => 'leads',

        's_ucf' => 'Trillionz Visit', //uppercase first
        'p_ucf' => 'Trillionz Visits',

        's_lcf' => 'trillionz_visit', //lowercase first
        'p_lcf' => 'trillionz_visits',

        '_id' => 'lead_id',
        'controller_name' => 'LeadController',
        'image_path' => 'Leads',
    ];
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'lead_date',
        'owner_name',
        'owner_mobile',
        'owner_email',
        'manager_name',
        'manager_social',
        'manager_email',
        'marketing_type',
        'marketing_name',
        'marketing_cost',
        'facebook',
        'instagram',
        'tiktok',
        'user_id',
        'type_id',
        'visit_id',
        'facility_id',
        'status',
        'offer_type',
        'offer_id',

        'wheels',
        'active',
        'has_agency',
        'intersted',
        'account_manager_id',

        'lat',
        'long'
    ];

    public function account_manager()
    {
        return $this->belongsTo(Employee::class, 'account_manager_id');
    }
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id')->with('type', 'category');
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
    public function offer()
    {
        return $this->belongsTo(Constant::class, 'offer_id')->withDefault(['name' => 'NA']);
    }
}
