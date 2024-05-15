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
        Schema::create('file_storage', function (Blueprint $table) {
            $table->uuid('file_storage_id')->primary();
            $table->uuid('penduduk_id')->index();
            $table->timestamps();
            $table->foreign('penduduk_id')->references('penduduk_id')->on('penduduk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_storage');
    }
};
