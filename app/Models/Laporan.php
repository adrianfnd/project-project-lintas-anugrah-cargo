<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'driver_id', 
        'surat_jalan_id', 
        'keluhan', 
        'image'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
