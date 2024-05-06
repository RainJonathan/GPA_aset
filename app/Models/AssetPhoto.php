<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetPhoto extends Model
{
    protected $table = "asset_photos";

    protected $fillable = [
        'asset_id',
        'photo_path',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    use HasFactory;
}
