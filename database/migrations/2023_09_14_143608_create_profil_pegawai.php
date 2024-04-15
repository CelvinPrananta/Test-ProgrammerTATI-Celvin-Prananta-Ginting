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
        Schema::create('profil_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('nip')->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_dokumen')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('jenis_pegawai')->nullable();
            $table->string('kedudukan_pns')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('tmt_pns')->nullable();
            $table->string('no_seri_karpeg')->nullable();
            $table->string('tmt_cpns')->nullable();
            $table->string('tingkat_pendidikan')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('bidang')->nullable();
            $table->string('dokumen_ktp')->nullable();
            $table->timestamps();
        });

        DB::table('profil_pegawai')->insert([
            ['user_id' => 'ID_00001', 'name' => 'Kelvin', 'email' => 'kelvin.masif@gmail.com', 'nip' => '0001'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profil_pegawai');
    }
};
