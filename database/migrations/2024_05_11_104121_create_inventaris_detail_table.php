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
        Schema::create('inventaris_detail', function (Blueprint $table) {
            $table->uuid('inventaris_detail_id')->primary();
            $table->uuid('inventaris_id')->index();
            $table->uuid('penduduk_id')->index();
            $table->integer('jumlah');
            $table->enum('kondisi', [
                'Normal',
                'Rusak',
                'Hilang',
            ]);
            $table->enum('status', [
                'Dipinjam',
                'Dikembalikan'
            ]);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->default(null);
            $table->timestamps();

            $table->foreign('inventaris_id')->references('inventaris_id')->on('inventaris')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_detail');
    }
};
