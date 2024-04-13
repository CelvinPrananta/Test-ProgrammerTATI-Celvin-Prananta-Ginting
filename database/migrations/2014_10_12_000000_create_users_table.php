<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_id');
            $table->string('email')->unique();
            $table->string('nip')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('join_date');
            $table->string('status')->nullable();
            $table->string('role_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('bidang')->nullable();
            $table->string('jenis_jabatan')->nullable();
            $table->string('eselon')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('tema_aplikasi')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['name'                         => 'Anton',
             'user_id'                      => 'ID_00001',
             'email'                        => 'anton@gmail.com',
             'nip'                          => '1905102006',
             'no_dokumen'                   => NULL,
             'join_date'                    => now()->toDayDateTimeString(),
             'status'                       => 'Active',
             'role_name'                    => 'Kepala Dinas',
             'avatar'                       => 'photo_defaults.jpg',
             'bidang'                       => NULL,
             'jenis_jabatan'                => 'Kepala Dinas',
             'eselon'                       => NULL,
             'password'                     => Hash::make('123456789'),
             'tema_aplikasi'                => 'Terang',
             'created_at' => now(),
             'updated_at' => now()
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
        Schema::dropIfExists('users');
    }
}