<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;

    protected $table = "tuan_rumah";

    protected $fillable = [
        'nama_penyewa',
        'no_ktp',
        'no_tlp',
        'wilayah_id',
        'tgl_awal',
        'tgl_akhir',
        'upah_jasa',
        'harga_sewa',
        'pendapatan_sewa',
        'tanggal_tunai',
        'harga_tunai',
        'tanggal_mandiri',
        'harga_mandiri',
        'tanggal_bca_leo',
        'harga_bca_leo',
        'tanggal_bca_sgls',
        'harga_bca_sgls',
        'saldo_piutang',
        'status_pengontrak',
        'denda',
        'keterangan',
        'bulan',
        'status_aktif',
    ];

    public function rekapAsets()
    {
        return $this->hasMany(Asset::class, 'id_transaksi', 'id');
    }
    public function wilayahPenyewa(){
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
