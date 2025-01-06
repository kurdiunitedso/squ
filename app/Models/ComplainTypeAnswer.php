<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplainTypeAnswer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'complain_id',
        'complain_type_id',
        'patient_clinic_team_id',
    ];
    public function complain()
    {
        return $this->belongsTo(Complain::class, 'complain_id');
    }

    public function complainType()
    {
        return $this->belongsTo(Constant::class, 'complain_type_id');
    }

    public function patientClinicTeam()
    {
        return $this->belongsTo(PatientClinicTeam::class, 'patient_clinic_team_id');
    }
}
