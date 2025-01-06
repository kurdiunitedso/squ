<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAgency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'marketing_agencies';


    public function bank_names()
    {
        return $this->belongsTo(Constant::class, 'bank_name')->withDefault(['name' => 'NA']);
    }

    public function branch()
    {
        return $this->belongsTo(MarketingAgencyBranch::class, 'branch_id')->withDefault(['name' => 'NA']);
    }

    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id')->withDefault(['name' => 'NA']);
    }


    public function branches()
    {
        return $this->hasMany(MarketingAgencyBranch::class);
    }

    public function teams()
    {
        return $this->hasMany(MarketingAgencyTeam::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function clients()
    {
        return $this->hasMany(Client::class, 'marketing_agency_id', 'id');
    }

}
