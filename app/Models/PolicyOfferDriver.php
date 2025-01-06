<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyOfferDriver extends Model
{
    use HasFactory;
    protected $table = 'drivers_under_24';
    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->belongsTo(City::class, 'vehilce_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
