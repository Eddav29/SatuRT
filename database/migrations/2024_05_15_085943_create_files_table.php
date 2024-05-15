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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('file_id')->primary();
            $table->uuid('file_storage_id')->index();
            $table->string('file_name');
            $table->string('file_extension');
            $table->string('file_type');
            $table->string('file_size');
            $table->string('file_url');
            $table->string('disk_name')->nullable();
            $table->timestamps();
            $table->foreign('file_storage_id')->references('file_storage_id')->on('file_storage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
