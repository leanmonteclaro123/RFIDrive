<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role',
        'full_name',
        'telephone',
        'province',
        'municipal',
        'barangay',
        'zipcode',
        'type',
        'codeID',
        'campus',
        'username',
        'email',
        'driver_license_front',
        'driver_license_back',
        'driver_license_expiry_date',
        'profile_picture',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }
    public function getDriverLicenseFrontAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getDriverLicenseBackAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getDriverLicenseExpiryDateAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Handle the profile picture URL
    public function getProfilePictureAttribute($value)
    {
        return $value ? asset($value) : asset('images/default-avatar.png'); // Return the default avatar if no profile picture is set
    }

    public function registrationRequests()
    {
        return $this->hasMany(RegistrationRequest::class, 'user_id');
    }


    


}
