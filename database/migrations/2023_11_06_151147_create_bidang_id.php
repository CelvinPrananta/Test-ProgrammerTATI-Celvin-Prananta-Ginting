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
        Schema::create('bidang_id', function (Blueprint $table) {
            $table->id();
            $table->string('bidang');
            $table->timestamps();
        });

        DB::table('bidang_id')->insert([
            ['bidang' => '-'],
            ['bidang' => 'Bidang IT'],
            ['bidang' => 'Bidang Manajemen'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_id');
    }
};