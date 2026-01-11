<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    protected $fillable = [
        'user_id',
        'mata_kuliah',
        'kode_mk',
        'prodi_id',
        'ruang_ujian',
        'tahun_ajaran',
        'hari_ujian',
        'tanggal_ujian',
        'waktu_mulai',
        'waktu_selesai',
        'jumlah_peserta',
        'jumlah_tidak_hadir',
        'catatan_peristiwa',
        'pengawas_1',
        'pengawas_2',
        'lampiran',
        'status',
        'catatan_admin',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'verified_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function absents()
    {
        return $this->hasMany(BapAbsent::class);
    }

    public function seats()
    {
        return $this->hasMany(BapSeat::class);
    }
}
