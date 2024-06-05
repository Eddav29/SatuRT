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
        Schema::create('kriteria_alternatif', function (Blueprint $table) {
            $table->id('kriteria_alternatif_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->unsignedBigInteger('alternatif_id');
            $table->float('nilai');
            $table->timestamps();

            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('alternatif_id')->references('alternatif_id')->on('alternatif')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_alternatif');
    }
};
