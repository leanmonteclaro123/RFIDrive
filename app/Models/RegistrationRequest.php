<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\Document;

class RegistrationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'vehicle_ids',
        'document_ids',
        'status',
        'admin_id',
        'comments'
    ];

    // Cast vehicle_ids and document_ids as arrays
    protected $casts = [
        'vehicle_ids' => 'array',
        'document_ids' => 'array',
    ];

    // Relationship to the user who made the request
    public function user()
    {
        return $this->belongsTo(LoginModel::class, 'user_id', 'id');
    }

    // Relationship to the admin who processed the request
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Custom accessor to retrieve vehicle models based on the stored vehicle IDs
    public function getVehiclesAttribute()
    {
        return Vehicle::whereIn('id', $this->vehicle_ids)->get();
    }

    // Custom accessor to retrieve document models based on the stored document IDs
    public function getDocumentsAttribute()
    {
        return Document::whereIn('id', $this->document_ids)->get();
    }
}
