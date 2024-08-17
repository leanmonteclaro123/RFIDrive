<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Automatically hash passwords when they are set
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }
}
