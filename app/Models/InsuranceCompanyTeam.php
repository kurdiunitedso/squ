<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCompanyTeam extends Model
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
    public function branch()
    {
        return $this->belongsTo(InsuranceCompanyBranch::class, 'branch_id')->withDefault(['name' => 'NA']);
    }
    public function department()
    {
        return $this->belongsTo(Constant::class, 'department_id')->where('module', 'insurance_module')->withDefault(['name' => 'NA']);
    }





}
