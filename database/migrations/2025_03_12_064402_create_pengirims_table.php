<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('pengirim', function (Blueprint $table) {
            $table->id('id_pengirim');
            $table->string('nama');
            $table->text('alamat');
            $table->string('nomor_telepon');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pengirims');
    }
};
