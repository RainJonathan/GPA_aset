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
            $table->string('no_ktp')->unique();
            $table->string('no_tlp');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->decimal('upah_jasa', 10, 2); // assuming decimal precision and scale
            $table->decimal('harga_sewa', 10, 2); // assuming decimal precision and scale
            $table->string('bank_pembayaran');
            $table->decimal('jumlah_pembayaran', 10, 2); // assuming decimal precision and scale
            $table->decimal('saldo_piutang', 10, 2); // assuming decimal precision and scale
            $table->enum('status_pengontrak', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->boolean('status_aktif')->default(true); // assuming boolean for active status
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
