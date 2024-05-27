<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overseer extends Model
{
    use HasFactory;

    protected $table = "users";

    protected $fillable = [
        'email',
        'username',
        'nik',
        'nama_user',
        'password',
        'id_wilayah',
        'status',
    ];

    public function wilayahKekuasaan(){
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function AssetPenaJawab(){
        return $this->belongsTo(Tiket::class, 'issue_by');
    }
}
