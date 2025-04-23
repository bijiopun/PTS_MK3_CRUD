<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('laporan_pengiriman', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->string('wilayah');
            $table->integer('jumlah_paket');
            $table->enum('status_pengiriman', ['pending', 'dalam perjalanan', 'selesai']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan__pengirimen');
    }
};
