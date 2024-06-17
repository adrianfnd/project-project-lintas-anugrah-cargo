<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Driver extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'created_by', 
        'name', 
        'image', 
        'phone_number', 
        'license_number', 
        'vehicle_name', 
        'address', 
        'status', 
        'rate'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'driver_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
