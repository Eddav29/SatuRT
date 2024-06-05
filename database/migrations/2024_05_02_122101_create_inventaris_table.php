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
            $table->uuid('inventaris_id')->primary();
            $table->uuid('penduduk_id')->index();
            $table->string('nama_inventaris');
            $table->string('merk');
            $table->string('warna');
            $table->integer('jumlah');
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
                'Pinjaman'
            ]);
            $table->string('keterangan');
            $table->string('foto_inventaris');
            $table->timestamps();

            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk')->onDelete('cascade')->onUpdate('cascade');

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
