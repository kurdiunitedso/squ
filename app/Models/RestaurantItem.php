<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'item_name',
        'restaurant_branch_id',
        'status',
        'restaurant_id',
        'preparation_time',
    ];


    public function branch()
    {
        return $this->belongsTo(RestaurantBranch::class,'restaurant_branch_id');
    }
    public function status()
    {
        return $this->belongsTo(Constant::class,'status');
    }
}
