<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $table = 'asets';

    protected $fillable = [
    'nama_aset',
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
