<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyOffer extends Model
{
    use HasFactory;

    protected $table='policy_offers';
    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->belongsTo(City::class, 'vehilce_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function captin()
    {
        return $this->belongsTo(Captin::class, 'captin_id')->with('city');
    }
    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company');
    }

    public function status()
    {
        return $this->belongsTo(Constant::class, 'status_id');
    }

    public function mortgaged()
    {
        return $this->belongsTo(Constant::class, 'mortgaged_type');
    }

    public function policyOffer_types()
    {
        return $this->belongsTo(Constant::class, 'policyOffer_type');
    }
    public function accident()
    {
        return $this->belongsTo(Constant::class, 'accident_desc');
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }


}
