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
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->string('nama_penyewa');
            $table->string('no_ktp');
            $table->string('no_tlp');
            $table->bigInteger('wilayah_id');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->decimal('upah_jasa',10,0)->nullable();
            $table->string('tanggal_bca_sgls')->nullable();
            $table->decimal('harga_bca_sgls',10,0)->nullable();
            $table->decimal('denda_bca_sgls',10,0)->nullable();
            $table->string('tanggal_bca_leo')->nullable();
            $table->decimal('harga_bca_leo',10,0)->nullable();
            $table->decimal('denda_bca_leo',10,0)->nullable();
            $table->string('tanggal_mandiri')->nullable();
            $table->decimal('harga_mandiri',10,0)->nullable();
            $table->decimal('denda_mandiri',10,0)->nullable();
            $table->string('tanggal_tunai')->nullable();
            $table->decimal('harga_tunai',10,0)->nullable();
            $table->decimal('denda_tunai',10,0)->nullable();
            $table->smallInteger('saldo_piutang');
            $table->smallInteger('status_pengontrak');
            $table->smallInteger('status_aktif')->default('1');
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
