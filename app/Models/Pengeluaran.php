<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = "pengeluaran";

    protected $fillable = [
        'id_aset',
        'pengeluaran',
        'keterangan',
        'updated_by',
    ];

    public function asset(){
        return $this->belongsTo(Asset::class, 'id_aset');
    }

    public function penanggungJawab(){
        return $this->belongsTo(Overseer::class, 'updated_by');
    }
}
