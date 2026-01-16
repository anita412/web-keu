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
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset', 100);
            $table->date('tanggal_beli');

            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_jual', 15, 2)->nullable();

            $table->integer('keuntungan')->nullable()->default(0);

            $table->enum('status', ['ada','terjual','hilang'])->default('ada');

            $table->enum('kategori', [
                'kendaraan',
                'tanah_&_rumah',
                'elektronik',
                'photography_&_videography',
                'lainnya'
            ])->default('kendaraan');

            $table->string('kategori_kustom', 100)->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};