<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTrillionSocial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table='client_trillion_socials';

    public function platform()
    {
        return $this->belongsTo(Constant::class, 'platform_id');
    }





}
