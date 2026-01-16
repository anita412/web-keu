<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';

    protected $fillable = [
    'nama_income',
    'tanggal_beli',
    'pemasukan',
    'pengeluaran',
    'status',
    'kategori',
    'kategori_kustom',
    'penyimpanan_income',
    'deskripsi',
];
}
