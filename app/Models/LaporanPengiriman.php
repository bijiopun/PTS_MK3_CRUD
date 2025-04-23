<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPengiriman extends Model
{

    protected $table = 'laporan_pengiriman';
    protected $primaryKey = 'id_laporan';
    protected $fillable = ['wilayah', 'jumlah_paket', 'status_pengiriman'];

    public function paket()
    {
        return $this->hasMany(Paket::class, 'id_laporan');
    }
}
