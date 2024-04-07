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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->uuid('pengajuan_id')->primary();
            $table->uuid('penduduk_id')->index();
            $table->unsignedBigInteger('status_id');
            $table->uuid('accepted_by')->nullable();
            $table->string('keperluan');
            $table->text('keterangan');
            $table->date('accepted_at')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk');
            $table->foreign('status_id')->references('status_id')->on('status');
            $table->foreign('accepted_by')->references('penduduk_id')->on('penduduk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
