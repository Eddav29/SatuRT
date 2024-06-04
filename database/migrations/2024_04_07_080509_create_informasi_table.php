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
        Schema::create('informasi', function (Blueprint $table) {
            $table->uuid('informasi_id')->primary();
            $table->uuid('penduduk_id')->index();
            $table->string('judul_informasi');
            $table->enum('jenis_informasi', [
                'Pengumuman',
                'Dokumentasi Kegiatan',
                'Dokumentasi Rapat',
                'Berita',
                'Artikel',
            ]);
            $table->text('isi_informasi');
            $table->string('thumbnail_url')->nullable();
            $table->text('excerpt');
            $table->timestamps();

            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
