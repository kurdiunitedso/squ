<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantEmployee extends Model
{
    use HasFactory;
    protected $fillable = [
        'restaurant_branch_id',
        'restaurant_id',
        'city_id',
        'name',
        'title',
        'whatsapp',
        'email',
        'title',
        'status',
        'mobile',
    ];

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function branch()
    {
        return $this->belongsTo(RestaurantBranch::class,'restaurant_branch_id');
    }
}
