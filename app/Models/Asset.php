<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use illuminate\Support\Facades\Log;

class Asset extends Model
{
    use HasFactory;

    protected $table = "rekap_aset";

    protected $fillable = [
        'host_id',
        'wilayah_id',
        'nama_aset',
        'jenis_aset',
        'kode_aset',
        'status_penyewaan',
        'alamat',
        'lantai',
        'no_rumah',
        'fasilitas',
        'deskripsi_aset',
        'pengeluaran',
        'created_at',
        'updated_at'
    ];

    public function tuanRumah(){
        return $this->belongsTo(Host::class, 'host_id');
    }
    public function photos()
    {
        return $this->hasMany(AssetPhoto::class, 'asset_id');
    }

    public function assetWilayah(){
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function tickets()
    {
        return $this->hasMany(Tiket::class, 'id_aset');
    }

    public function pengeluaran(){
        return $this->hasMany(Pengeluaran::class, 'id_aset');
    }

    public function previousOwners()
    {
        return $this->hasManyThrough(
            Host::class,
            AssetOwnershipHistory::class,
            'asset_id',
            'id',
            'id',
            'previous_owner_id'
        )->orderBy('ownership_changed_at', 'desc');
    }

    public function totalPengeluaran(){
        $total = 0;
        if ($this->relationLoaded('tickets') && $this->tickets !== null) {
            foreach($this->tickets as $item){
                $total += $item->biaya_perbaikan;
            }
        } else {
            Log::info('Tickets not loaded or null');
        }

        if ($this->relationLoaded('pengeluaran') && $this->pengeluaran !== null) {
            foreach($this->pengeluaran as $item){
                $total += $item->pengeluaran;
            }
        } else {
            Log::info('Pengeluaran not loaded or null');
        }

        return $total;
    }
}

