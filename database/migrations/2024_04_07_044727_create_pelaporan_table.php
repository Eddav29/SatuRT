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
        Schema::create('pelaporan', function (Blueprint $table) {
            $table->id('pelaporan_id');
            $table->uuid('pengajuan_id')->index();
            $table->enum('jenis_pelaporan', [
                'Pengaduan',
                'Kritik',
                'Saran',
                'Lainnya'
            ]);
            $table->string('image_url')->nullable();
            $table->foreign('pengajuan_id')->references('pengajuan_id')->on('pengajuan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporan');
    }
};
