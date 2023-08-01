<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penagihan extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'penagihan';
    protected $primaryKey = 'id_penagihan';
    protected $fillable = [
        'keperluan',
        'nomor_sp2d',
        'tanggal_sp2d',
        'tanggal_terbit',
        'tanggal_cair',
        'potongan_ppn',
        'potongan_pph',
        'potongan_lainnya',
        'keterangan_potongan_lainnya',
        'kas_masuk',
        'tanggal_pengajuan',
        'status_penagihan',
        'status_aktivitas',
        'id_proyek',
        'id_rekening'
    ];

    public $autoIncrement = false;
}
