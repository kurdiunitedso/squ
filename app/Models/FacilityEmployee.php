<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityEmployee extends Model
{
    use HasFactory;
    protected $fillable = [
        'facility_branch_id',
        'facility_id',
        'city_id',
        'name',
        'title',
        'whatsapp',
        'email',
        'title',
        'status',
        'mobile',
    ];

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function branch()
    {
        return $this->belongsTo(FacilityBranch::class,'facility_branch_id');
    }
}
