<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetOwnershipHistory extends Model
{
    protected $table = "asset_ownership_histories";

    public $timestamps = false;

    protected $fillable = [
        'asset_id',
        'previous_owner_id',
        'ownership_changed_at',
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

