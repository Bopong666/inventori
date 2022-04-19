<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
