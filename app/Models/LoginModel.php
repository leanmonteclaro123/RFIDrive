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
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }
}
