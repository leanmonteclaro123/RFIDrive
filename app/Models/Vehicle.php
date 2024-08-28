<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_plate',
        'province',
        'make', 
        'model', 
        'year', 
        'color', 
        'registered_owner_name', 
        'registered_owner_province',
        'registered_owner_municipality',
        'registered_owner_barangay',
        'registered_owner_zipcode'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(LoginModel::class, 'user_id'); 
    }
}
