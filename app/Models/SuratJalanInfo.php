<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalanInfo extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan_info';

    protected $fillable = [
        'surat_jalan_id',
        'information',
        'latitude',
        'longitude',
        'checkpoint_time'
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
