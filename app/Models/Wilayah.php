<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayahs';

    protected $fillable =[
        'nama_wilayah',
        'kode_pos'
    ];

    public function wilayahAsset(){
        return $this->hasMany(Asset::class, 'wilayah_id');
    }

    public function wilayahPJ(){
        return $this->hasMany(Overseer::class, 'id_wilayah');
    }
}
