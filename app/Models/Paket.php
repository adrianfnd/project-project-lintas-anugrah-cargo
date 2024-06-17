<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tracking_number', 
        'packet_name', 
        'packet_type',
        'sender_name', 
        'sender_address', 
        'sender_phone',
        'sender_latitude', 
        'sender_longitude', 
        'receiver_name', 
        'receiver_address', 
        'receiver_phone',
        'receiver_latitude', 
        'receiver_longitude', 
        'weight', 
        'dimensions', 
        'description', 
        'image', 
        'status',
        'surat_jalan_id',
        'create_by'
    ];

    public function suratJalan()
    {
        return $this->hasMany(SuratJalan::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'created_by');
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
