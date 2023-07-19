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
        'tahun_anggaran',
        'pengguna_jasa',
        'nilai_kontrak',
        'waktu_mulai',
        'waktu_selesai',
        'pic',
        'status_proyek',
        'slug',
    ];

    public $autoIncrement = false;
}
