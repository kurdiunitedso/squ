<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complain extends Model
{
    use SoftDeletes;

    protected $appends = ['delay'];

    protected $fillable = [
        'patient_id',
        'complain_date',
        'complain',
        'notes',
        'assigned_user_id',
        'source_type',
        'source_id',
        'status',
        'user_id',
    ];

    protected $casts = [
        'complain_date' => 'date:Y-m-d',
    ];



    public function getDelayAttribute()
    {
        if ($this->status == 'solved')
            return null;
        $complainDate = $this->complain_date;
        $currentDate = Carbon::now();
        $delay = 0;
        if ($currentDate->greaterThan($complainDate)) {
            $delay = $currentDate->diffInDays($complainDate);
        }

        return $delay;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function source()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typeAnswers()
    {
        return $this->hasMany(ComplainTypeAnswer::class);
    }
}
