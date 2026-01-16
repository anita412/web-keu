<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_income',100);
            $table->date('tanggal_beli')->default(now());
            $table->decimal('pemasukan',15,2);
            $table->decimal('pengeluaran',15,2);
            $table->integer('keuntungan')->nullable()->default(0);      
            $table->enum('status', ['ada','terjual','hilang'])->default('ada');
            $table->enum('kategori', ['korean_shipping','samaji_store','photosport','fotoyu', 'sawah','hidroponik','lainnya'])->default('korean_shipping');
            $table->string('kategori_kustom', 100)->nullable();
            $table->string('penyimpanan_income',100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};