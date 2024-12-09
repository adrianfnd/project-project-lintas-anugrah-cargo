<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'driver_id', 
        'list_paket', 
        'status', 
        'sender',
        'sender_latitude', 
        'sender_longitude', 
        'receiver',
        'receiver_latitude', 
        'receiver_longitude', 
        'checkpoint_latitude', 
        'checkpoint_longitude',
        'start_delivery_time',
        'estimated_delivery_time',
        'end_delivery_time',
        'rate'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
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
