<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number', 
        'sender_name', 
        'sender_address', 
        'sender_latitude', 
        'sender_longitude', 
        'receiver_name', 
        'receiver_address', 
        'receiver_latitude', 
        'receiver_longitude', 
        'weight', 
        'dimensions', 
        'description', 
        'image', 
        'status'
    ];

    public function suratJalan()
    {
        return $this->hasMany(SuratJalan::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function riwayatPaket()
    {
        return $this->hasMany(RiwayatPaket::class);
    }
}
