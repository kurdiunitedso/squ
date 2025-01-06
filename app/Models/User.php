<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'name',
        'mobile',
        'branch_id',
        'email',
        'password',
        'active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime'
    ];


    public function canImpersonate()
    {
        return $this->hasRole('super-admin') || $this->hasPermissionTo('impersonate');
        // // For example
        // return $this->id == 1;
    }

    public function branch()
    {
        return $this->belongsTo(Constant::class, 'branch_id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
    public function scopeActive(Builder $query)
    {
        $query->where('active', 1);
    }
    public static function  getUserFullName($id)
    {
        if (User::find($id))
            return User::find($id)->name;
    }
}
