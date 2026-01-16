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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('nama_maintenance',100);
            $table->date('tanggal_beli')->default(now());
            $table->decimal('pemasukan',15,2);
            $table->decimal('pengeluaran',15,2);
            $table->integer('keuntungan')->nullable()->default(0);      
            $table->enum('status', ['ada','terjual','hilang'])->default('ada');
            $table->enum('kategori', ['cadangan_bulanan','seveneleven','bunga_hana','rumah','lainnya'])->default('cadangan_bulanan');
            $table->string('kategori_kustom', 100)->nullable();
            $table->string('penyimpanan_maintenance',100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};