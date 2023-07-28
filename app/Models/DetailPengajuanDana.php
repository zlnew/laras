<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPengajuanDana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_pengajuan_dana';
    protected $primaryKey = 'id_detail_pengajuan_dana';
    protected $fillable = [
        'uraian',
        'jumlah_pengajuan',
        'jenis_pembayaran',
        'status_persetujuan',
        'id_pengajuan_dana',
        'id_detail_rap',
        'id_rekening'
    ];
}
