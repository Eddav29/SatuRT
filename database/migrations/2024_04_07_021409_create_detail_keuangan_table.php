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
        Schema::create('detail_keuangan', function (Blueprint $table) {
            $table->id('detail_keuangan_id');
            $table->unsignedBigInteger('keuangan_id');
            $table->string('judul');
            $table->enum('jenis_keuangan', ['Pemasukan', 'Pengeluaran']);
            $table->enum('asal_keuangan', ['Donasi', 'Iuran Warga', 'Kas Umum', 'Dana Darurat',  'Lainnya']);
            $table->integer('nominal');
            $table->text('keterangan');
            $table->timestamps();
            $table->foreign('keuangan_id')->references('keuangan_id')->on('keuangan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_keuangan');
    }
};
