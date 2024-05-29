<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Host;
use App\Models\Tiket;
use App\Models\Pengeluaran;
use App\Models\AssetPhoto;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Foreach_;

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
        )->orderBy('asset_id', 'desc');
    }

    public function totalPengeluaran()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $total = $this->tickets()
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('biaya_perbaikan');

        $total += $this->pengeluaran()
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('pengeluaran');

        return $total;
    }
}