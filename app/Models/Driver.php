<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 
        'name', 
        'image', 
        'phone_number', 
        'license_number', 
        'vehicle_name', 
        'address', 
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
