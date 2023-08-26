<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanDana extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'pengajuan_dana';
    protected $primaryKey = 'id_pengajuan_dana';
    protected $fillable = [
        'keperluan',
        'tanggal_pengajuan',
        'jenis_transaksi',
        'status_pengajuan',
        'status_aktivitas',
        'id_proyek'
    ];
    
    public $autoIncrement = false;
}
