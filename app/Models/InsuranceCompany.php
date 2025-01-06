<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCompany extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'insurance_companies';

    public function bank_names()
    {
        return $this->belongsTo(Constant::class, 'bank_name')->where('module', 'insurance_module')->withDefault(['name' => 'NA']);
    }

    public function branch()
    {
        return $this->belongsTo(InsuranceCompanyBranch::class, 'branch_id')->withDefault(['name' => 'NA']);
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id')->where('module', 'insurance_module')->withDefault(['name' => 'NA']);
    }


    public function branches()
    {
        return $this->hasMany(InsuranceCompanyBranch::class);
    }

    public function teams()
    {
        return $this->hasMany(InsuranceCompanyTeam::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function clients()
    {
        return $this->hasMany(Client::class, 'insurance_company_id', 'id');
    }

}
