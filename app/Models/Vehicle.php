<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function insurance_types()
    {
        return $this->belongsTo(Constant::class, 'insurance_type')->withDefault(['name' => 'NA']);
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function captin()
    {
        return $this->belongsTo(Captin::class, 'captin_id')->withDefault(['name' => 'NA']);
    }
    public function vehicle_types()
    {
        return $this->belongsTo(Constant::class, 'vehicle_type')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }
    public function insurance_companys()
    {
        return $this->belongsTo(Constant::class, 'insurance_company')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }
    public function motor_ccs()
    {
        return $this->belongsTo(Constant::class, 'motor_cc')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }
    public function vehicle_models()
    {
        return $this->belongsTo(Constant::class, 'vehicle_model')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }

    public function fuel_types()
    {
        return $this->belongsTo(Constant::class, 'fuel_type')->where('module', 'captin_module')->withDefault(['name' => 'NA']);
    }






















}
