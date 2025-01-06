<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantBranch extends Model
{
    use HasFactory;
    protected $fillable = [
        'telephone',
        'city_id',
        'restaurant_id',
        'address',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
}
