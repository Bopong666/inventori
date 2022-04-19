<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function masuk()
    {
        return $this->hasMany(Masuk::class);
    }

    public function getJumlahAttribute()
    {
        return $this->masuk->sum('jumlah');
    }
    public function permintaan()
    {
        return $this->hasMany(Permintaan::class);
    }
}
