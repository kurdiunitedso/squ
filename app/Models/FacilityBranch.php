<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityBranch extends Model
{
    use HasFactory;
    protected $fillable = [
        'telephone',
        'city_id',
        'facility_id',
        'address',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class,'facility_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
}
