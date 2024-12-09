<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPaket extends Model
{
    use HasFactory;

    protected $table = 'riwayat_paket';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'driver_id', 
        'list_paket', 
        'surat_jalan_id', 
        'laporan_id', 
        'status'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
