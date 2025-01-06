<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\HasLocalizedNameAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Visit extends Model implements Auditable
{
    use HasFactory, SoftDeletes, EagerLoadPivotTrait, HasLocalizedNameAttribute, AuditingAuditable;

    // protected $guarded = ['id'];
    protected $fillable = [
        'visit_request_id',
        'visit_date',
        'visit_time',
        'period',
        'visit_type',
        'status',
        'rate_company',
        'rate_captin',
        'visit_name',
        'telephone',
        'employee',
        'details',
        'ticket_answer',
        'visit_number',
        'city_id',
        'visit_category',
        'last_date',
        'purpose',
        'department',
        'source',
        'call_id'
    ];
    public const ui = [
        'table' => 'visits',
        'route' => 'visits',

        's_ucf' => 'Wheels Visit', //uppercase first
        'p_ucf' => 'Wheels Visits',

        's_lcf' => 'wheels_visit', //lowercase first
        'p_lcf' => 'wheels_visits',

        '_id' => 'visit_id',
        'controller_name' => 'VisitController',
        'image_path' => 'visits',
    ];
    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id')->withDefault(['name' => 'NA']);
    }
    public function categories()
    {
        return $this->belongsTo(Constant::class, 'visit_category')->withDefault(['name' => 'NA']);
    }

    public function statuses()
    {
        return $this->belongsTo(Constant::class, 'status')->withDefault(['name' => 'NA']);
    }
    public function visit_types()
    {
        return $this->belongsTo(Constant::class, 'visit_type')->withDefault(['name' => 'NA']);
    }
    public function periods()
    {
        return $this->belongsTo(Constant::class, 'period')->withDefault(['name' => 'NA']);
    }
    public function priorities()
    {
        return $this->belongsTo(Constant::class, 'priority')->withDefault(['name' => 'NA']);
    }

    public function employees()
    {
        return $this->belongsTo(User::class, 'employee')->withDefault(['name' => 'NA']);
    }

    public function visitRequests()
    {
        return $this->belongsTo(VisitRequest::class, 'id', 'visit_request_id');
    }
}
