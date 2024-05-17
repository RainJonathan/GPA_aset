<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketImage extends Model
{
    use HasFactory;

    protected $table = "tiket_image";

    protected $fillable = [
        'tiket_id',
        'before_photo',
        'after_photo',
    ];

    public function ticket(){
        return  $this->belongsTo(Tiket::class);
    }
}
