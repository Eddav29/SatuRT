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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id('inventaris_id');
            $table->uuid('penduduk_id')->index();
            $table->string('nama_inventaris');
            $table->string('merk');
            $table->string('warna');
            $table->integer('jumlah');
            $table->enum('kondisi', [
                'Cukup',
                'Baik',
                'Bagus',
                'Cacat',
                'Rusak',
            ]);
            $table->enum('jenis', [
                'Furnitur',
                'Elektronik',
                'ATK',
                'Kendaraan',
                'Perlengkapan',
                'Lainnya',
            ]);
            $table->enum('sumber', [
                'Hibah',
                'Beli',
                'Donasi',
                'Bantuan',
                'Pinjaman',
                'Lainnya',
            ]);
            $table->string('keterangan');
            $table->string('foto_inventaris');
            $table->timestamps();

            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
