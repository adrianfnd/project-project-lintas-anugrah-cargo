<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ManagerOperasional extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'managers_operasional';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'created_by', 
        'name', 
        'phone_number', 
        'address'
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
