<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\vendorInfo;
use APP\Models\driver;
use App\Models\Driver as ModelsDriver;
use App\Models\vehicle;
use App\Models\servicearea;
use App\Models\trip;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
public function vendorinfo()
{
    return $this->hasMany(vendorInfo::class,'user_id');
}
public function driver()
{
    return $this->hasMany(ModelsDriver::class,'user_id');
}
public function SelfDriverProfile()
{
    return $this->hasMany(ModelsDriver::class,'SelfDriverProfileId');
}
public function vehicle()
{
    return $this->hasMany(vehicle::class,'user_id');
}
public function vendor_service_areas()
{
    return $this->hasMany(servicearea::class,'user_id');
}
public function trip()
{
    return $this->hasMany(trip::class,'customer_id');
}
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
        'roles' => 'json',
    ];
    
}
