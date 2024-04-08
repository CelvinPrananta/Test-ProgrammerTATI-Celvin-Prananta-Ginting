<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ruangan_id', function (Blueprint $table) {
            $table->id();
            $table->string('ruangan');
            $table->string('jumlah_tempat_tidur')->nullable();
            $table->timestamps();
        });

        DB::table('ruangan_id')->insert([
            ['ruangan' => '-'],
            ['ruangan' => 'Ruang IGD Terpadu'],
            ['ruangan' => 'Ruang Bedah Central'],
            ['ruangan' => 'RR'],
            ['ruangan' => 'Ruang Poli Jantung'],
            ['ruangan' => 'Ruang Poli Kelamin dan Kulit'],
            ['ruangan' => 'Ruang Poli Saraf'],
            ['ruangan' => 'Ruang Poli Gigi'],
            ['ruangan' => 'Ruang Poli Dalam'],
            ['ruangan' => 'Ruang Poli Mata'],
            ['ruangan' => 'Ruang Poli THT'],
            ['ruangan' => 'Ruang Poli Paru'],
            ['ruangan' => 'Ruang Poli Umum'],
            ['ruangan' => 'Ruang Poli Anak'],
            ['ruangan' => 'Ruang Poli Kandungan'],
            ['ruangan' => 'Ruang Poli Jiwa'],
            ['ruangan' => 'Ruang Poli Orthopedi'],
            ['ruangan' => 'Ruang Poli Dots'],
            ['ruangan' => 'Ruang Hemodialisis (HD)'],
            ['ruangan' => 'Ruang Kebidanan'],
            ['ruangan' => 'Ruang Pinang'],
            ['ruangan' => 'Ruang Perinatologi'],
            ['ruangan' => 'Ruang Cemara'],
            ['ruangan' => 'Ruang HCU Bougenvill'],
            ['ruangan' => 'Ruang ICU'],
            ['ruangan' => 'Ruang ICCU'],
            ['ruangan' => 'Ruang Asoka'],
            ['ruangan' => 'Ruang Pinus'],
            ['ruangan' => 'Ruang Wijaya Kusuma'],
            ['ruangan' => 'Ruang Pavilliun'],
            ['ruangan' => 'Ruang Palem/PICU'],
            ['ruangan' => 'Ruang Unit Stroke'],
            ['ruangan' => 'Ruang Bidara/Ranap Jiwa'],
            ['ruangan' => 'Ruang Lain-Lain/Non Perawatan'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan_id');
    }
};
