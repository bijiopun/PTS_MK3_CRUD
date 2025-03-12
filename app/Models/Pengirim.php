<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengirim extends Model
{

    protected $table = 'pengirim';
    protected $primaryKey = 'id_pengirim';
    protected $fillable = ['nama', 'alamat', 'nomor_telepon'];

    public function paket()
    {
        return $this->hasMany(Paket::class, 'id_pengirim');
    }
}
