<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyek extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    
    protected $table = 'proyek';
    protected $primaryKey = 'id_proyek';
    protected $fillable = [
        'nama_proyek',
        'nomor_kontrak',
        'tanggal_kontrak',
        'pengguna_jasa',
        'penyedia_jasa',
        'tahun_anggaran',
        'nomor_spmk',
        'tanggal_spmk',
        'nilai_kontrak',
        'tanggal_mulai',
        'durasi',
        'tanggal_selesai',
        'id_user',
        'id_rekening',
        'status_proyek'
    ];

    public $autoIncrement = false;
}
