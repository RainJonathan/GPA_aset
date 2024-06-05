<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostAssetHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'asset_id',
        'start_date',
        'end_date',
        'denda_bca',
        'denda_bri',
        'denda_mandiri',
        'denda_tunai',
        'harga_sewa',
        'status_penyewaan',
    ];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}