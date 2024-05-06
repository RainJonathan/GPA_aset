<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tuan_rumah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyewa');
            $table->string('no_ktp');
            $table->string('no_tlp');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->decimal('upah_jasa',10,0);
            $table->decimal('harga_sewa',10,0);
            $table->string('bank_pembayaran');
            $table->decimal('jumlah_pembayaran',10,0);
            $table->smallInteger('saldo_piutang');
            $table->smallInteger('status_pengontrak');
            $table->smallInteger('status_aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuan_rumah');
    }
};
