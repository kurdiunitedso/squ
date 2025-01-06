<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAgencyBranch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function marketing_agency()
    {
        return $this->belongsTo(MarketingAgency::class, 'marketing_agency_id')->withDefault(['name' => 'NA']);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withDefault(['name' => 'NA']);
    }





}
