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
        'tgl_awal',
        'tgl_akhir',
        'upah_jasa',
        'harga_sewa',
        'pendapatan_sewa',
        'tgl_tunai',
        'jumlah_tunai',
        'tgl_mandiri',
        'jumlah_mandiri',
        'tgl_bca_leo',
        'jumlah_bca_leo',
        'tgl_bca_sgls',
        'jumlah_bca_sgls',
        'total',
        'saldo_piutang',
        'status_pengontrak',
        'keterangan',
        'bulan',
        'aktif',
    ];

    public function rekapAsets()
    {
        return $this->hasMany(Asset::class, 'id_transaksi', 'id');
    }
}
