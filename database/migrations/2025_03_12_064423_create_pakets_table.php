<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->id('id_paket');
            $table->unsignedBigInteger('id_pengirim');
            $table->unsignedBigInteger('id_penerima');
            $table->unsignedBigInteger('id_laporan');
            $table->decimal('berat', 8, 2);
            $table->enum('status_pengiriman', ['pending', 'proses', 'dikirim', 'diterima']);
            $table->string('jenis');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_pengirim')->references('id_pengirim')->on('pengirim')->onDelete('cascade');
            $table->foreign('id_penerima')->references('id_penerima')->on('penerima')->onDelete('cascade');
            $table->foreign('id_laporan')->references('id_laporan')->on('laporan_pengiriman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
