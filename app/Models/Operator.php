<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 
        'name', 
        'phone_number', 
        'address', 
        'region', 
        'region_latitude', 
        'region_longitude'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'operator_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
