<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'admin_id', 
        'manager_operasional_id',
        'operator_id', 
        'driver_id', 
        'name', 
        'username', 
        'email', 
        'password', 
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function manager_operasional()
    {
        return $this->belongsTo(ManagerOperasional::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
