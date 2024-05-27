<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 
        'paket_id', 
        'status', 
        'latitude', 
        'longitude'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
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
