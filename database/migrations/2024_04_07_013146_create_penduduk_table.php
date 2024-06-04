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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->uuid('penduduk_id')->primary();
            $table->uuid('kartu_keluarga_id')->index();
            $table->uuid('user_id')->index()->nullable();
            $table->char('nik', 16)->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('pekerjaan');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Lainnya']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('status_hubungan_dalam_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Cucu', 'Ayah', 'Ibu', 'Saudara', 'Mertua', 'Menantu', 'Cucu Menantu', 'Cicit', 'Keluarga Lain'])->nullable();
            $table->enum('status_perkawinan', ['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->enum('status_kehidupan', ['Hidup', 'Meninggal'])->default('Hidup');
            $table->string('foto_ktp')->nullable();
            $table->enum('status_penduduk', ['Domisili', 'Non Domisili']);
            $table->integer('nomor_rt');
            $table->integer('nomor_rw');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kota');
            $table->timestamps();

            $table->foreign('kartu_keluarga_id')->references('kartu_keluarga_id')->on('kartu_keluarga')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
