<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = "tiket_masalah";

    protected $fillable = [
        'id_aset',
        'keterangan',
        'penyelesaian',
        'biaya_perbaikan',
        'status',
        'user_id',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_aset');
    }

    public function photo(){
        return $this->hasMany(TiketImage::class, 'tiket_id');
    }

    public function penanggungJawab(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
