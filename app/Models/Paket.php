<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{

    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    protected $fillable = ['id_pengirim', 'id_penerima', 'id_laporan', 'berat', 'status_pengiriman', 'jenis'];

    public function pengirim()
    {
        return $this->belongsTo(Pengirim::class, 'id_pengirim');
    }

    public function penerima()
    {
        return $this->belongsTo(Penerima::class, 'id_penerima');
    }

    public function laporanPengiriman()
    {
        return $this->belongsTo(LaporanPengiriman::class, 'id_laporan');
    }

    
}
