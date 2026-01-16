<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saham extends Model
{
    protected $table = 'sahams';

    protected $fillable = [
    'nama_saham',
    'tanggal_beli',
    'harga_beli',
    'harga_jual',
    'keuntungan',
    'status',
    'kategori',
    'kategori_kustom',
    'deskripsi',
];
}
