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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id('keuangan_id');
            $table->uuid('penduduk_id')->index();
            $table->integer('total_keuangan');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
