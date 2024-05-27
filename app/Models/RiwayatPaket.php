<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPaket extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 
        'paket_id', 
        'surat_jalan_id', 
        'status'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
