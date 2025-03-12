<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{

    protected $table = 'penerima';
    protected $primaryKey = 'id_penerima';
    protected $fillable = ['nama', 'alamat', 'nomor_telepon'];

    public function paket()
    {
        return $this->hasMany(Paket::class, 'id_penerima');
    }
}