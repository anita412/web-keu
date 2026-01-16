<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $table = 'savings';

    protected $fillable = [
    'nama_saving',
    'tanggal_beli',
    'pemasukan',
    'pengeluaran',
    'status',
    'kategori',
    'kategori_kustom',
    'penyimpanan_saving',    
    'deskripsi',
];
}
