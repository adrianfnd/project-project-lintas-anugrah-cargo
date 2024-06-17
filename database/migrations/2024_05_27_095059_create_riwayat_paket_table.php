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
        Schema::create('riwayat_paket', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->string('list_paket');
            $table->uuid('surat_jalan_id');
            $table->foreign('surat_jalan_id')->references('id')->on('surat_jalan');
            $table->uuid('laporan_id')->nullable();
            $table->foreign('laporan_id')->references('id')->on('laporan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_paket');
    }
};
