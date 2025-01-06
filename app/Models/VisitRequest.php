<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];
    protected $fillable = [
        'visit_name',
        'mobile',
        'visit_date',
        'visit_category',
        'priority',
        'visit_type',
        'purpose',
        'status',
        'requester',
        'employee',
        'details',
        'last_date',
        'telephone',
        'city_id',
        'department',
        'visitable_type',
        'visitable_id'
    ];
    public const ui = [
        'table' => 'visit_requests',
        'route' => 'visit_requests',

        's_ucf' => 'Visit Request', //uppercase first
        'p_ucf' => 'Visit Requests',

        's_lcf' => 'visit_request', //lowercase first
        'p_lcf' => 'visit_requests',

        '_id' => 'visit_request_id',
        'controller_name' => 'VisitRequestController',
        'image_path' => 'visit_requests',
    ];

    public function purposes()
    {
        return $this->belongsTo(Constant::class, 'purpose')->withDefault(['name' => 'NA']);
    }

    public function statuses()
    {
        return $this->belongsTo(Constant::class, 'status')->withDefault(['name' => 'NA']);
    }

    public function visit_types()
    {
        return $this->belongsTo(Constant::class, 'visit_type')->withDefault(['name' => 'NA']);
    }

    public function employees()
    {
        return $this->belongsTo(User::class, 'employee')->withDefault(['name' => 'NA']);
    }

    public function priorities()
    {
        return $this->belongsTo(Constant::class, 'priority')->withDefault(['name' => 'NA']);
    }


    public function categories()
    {
        return $this->belongsTo(Constant::class, 'visit_category')->withDefault(['name' => 'NA']);
    }
    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function requesters()
    {
        return $this->belongsTo(User::class, 'requester')->withDefault(['name' => 'NA']);
    }
    public function visits()
    {
        return $this->hasMany(Visit::class, 'visit_request_id', 'id');
    }

    public function visitable()
    {
        return $this->morphTo();
    }

    public function source()
    {
        return $this->morphTo();
    }
}
