<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCompanyBranch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function insurance_company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id')->withDefault(['name' => 'NA']);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withDefault(['name' => 'NA']);
    }





}
