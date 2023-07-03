<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPengajuanDana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_pengajuan_dana';
    protected $primaryKey = 'id_detail_pengajuan_dana';
    protected $fillable = [
        'id_pengajuan_dana',
        'id_detail_rap',
        'uraian',
        'jumlah_pengajuan',
        'jenis_pembayaran',
        'nama_rekening',
        'nomor_rekening',
        'nama_bank'
    ];

    public function pengajuan_dana(): HasOne
    {
        return $this->hasOne(PengajuanDana::class, 'id_pengajuan_dana', 'id_pengajuan_dana');
    }

    public function detail_rap(): HasOne
    {
        return $this->hasOne(DetailRAP::class, 'id_detail_rap', 'id_detail_rap');
    }
}
