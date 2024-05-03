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
        Schema::create('persuratan', function (Blueprint $table) {
            $table->id('persuratan_id');
            $table->uuid('pengajuan_id')->index();
            $table->enum('jenis_surat', [
                'Surat Pengantar KTP',
            'Surat Pengantar Kartu keluarga',
            'Surat Pengantar Akta Kelahiran',
            'Surat Pengantar Akta Kematian',
            'Surat Pengantar SKCK',
            'Surat Pengantar Nikah',
            'Lainnya',
            ]);
            $table->string('nomor_surat')->nullable();
            $table->string('dokumen_url')->nullable();

            $table->foreign('pengajuan_id')->references('pengajuan_id')->on('pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persuratan');
    }
};
