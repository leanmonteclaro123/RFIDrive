<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 
        'type', 
        'file_path', 
        'expiry_date'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
