<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenances';

    protected $fillable = [
    'nama_maintenance',
    'tanggal_beli',
    'pemasukan',
    'pengeluaran',
    'status',
    'kategori',
    'kategori_kustom',
    'penyimpanan_maintenance',
    'deskripsi',
];
}
