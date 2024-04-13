<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHarian extends Model
{
    use HasFactory;

    protected $table = 'catatan_harian';

    protected $fillable = [
        'user_id',
        'name',
        'nip',
        'catatan_kegiatan',
        'tanggal_kegiatan',
        'status_pengajuan',
        'persetujuan_kepala_dinas',
        'persetujuan_kepala_bidang',
    ];

    public function posisi_jabatan()
    {
        return $this->belongsTo(PosisiJabatan::class, 'jabatan', 'jabatan');
    }
}