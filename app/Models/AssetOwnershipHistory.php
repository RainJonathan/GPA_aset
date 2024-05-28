<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetOwnershipHistory extends Model
{
    protected $table = "asset_ownership_histories";

    protected $fillable = [
        'asset_id',
        'previous_owner_id',
        'status_penyewaan',
        'harga_sewa',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function previousOwner()
    {
        return $this->belongsTo(Host::class, 'previous_owner_id');
    }
}

