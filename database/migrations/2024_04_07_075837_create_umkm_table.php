<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->uuid('umkm_id')->primary();
            $table->uuid('penduduk_id')->index();
            $table->string('nama_umkm');
            $table->enum('jenis_umkm', [
                'Makanan',
                'Minuman',
                'Makanan dan Minuman',
                'Pakaian',
                'Peralatan',
                'Jasa',
                'Lainnya'
            ]);
            $table->string('keterangan');
            $table->string('alamat');
            $table->string('nomor_telepon');
            $table->string('lokasi_url');
            $table->string('thumbnail_url');
            $table->enum('status', ['Aktif', 'Nonaktif']);
            $table->string('lisence_image_url');
            $table->timestamps();

            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
