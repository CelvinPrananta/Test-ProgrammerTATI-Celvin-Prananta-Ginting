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
        Schema::create('catatan_harian', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nip')->nullable();
            $table->string('catatan_kegiatan')->nullable();
            $table->string('tanggal_kegiatan')->nullable();
            $table->string('status_pengajuan')->nullable();
            $table->string('persetujuan_kepala_dinas')->nullable();
            $table->string('persetujuan_kepala_bidang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_harian');
    }
};
