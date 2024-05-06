<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Host;
use App\Models\AssetPhoto;

class Asset extends Model
{
    use HasFactory;

    protected $table = "rekap_aset";

    public $timestamps = false;

    protected $fillable = [
        'host_id',
        'wilayah',
        'nama_aset',
        'jenis_aset',
        'kode_aset',
        'alamat',
        'lantai',
        'no_rumah',
        'fasilitas',
        'status',
        'created_at',
        'updated_at'
    ] ;

    public function tuanRumah(){
        return $this->belongsTo(Host::class, 'host_id');
    }
    public function photos()
    {
        return $this->hasMany(AssetPhoto::class, 'asset_id');
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
}
