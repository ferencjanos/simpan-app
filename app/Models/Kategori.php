<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
    ];

    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class);
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class);
    }
}