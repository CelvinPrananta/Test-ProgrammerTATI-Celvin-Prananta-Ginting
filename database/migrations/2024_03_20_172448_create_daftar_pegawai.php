<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_id');
            $table->string('nip')->nullable();
            $table->string('role_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('bidang')->nullable();
            $table->string('kedudukan_pns')->nullable();
            $table->string('jenis_pegawai')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('gol_ruang_awal')->nullable();
            $table->string('gol_ruang_akhir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('tingkat_pendidikan')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->timestamps();
        });

        DB::table('daftar_pegawai')->insert([
            ['name'                         => 'Kelvin',
             'user_id'                      => 'ID_00001',
             'nip'                          => '0001',
             'role_name'                    => 'Kepala Dinas',
             'avatar'                       => 'photo_defaults.jpg'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_pegawai');
    }
};