<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPencairanDana extends Model
{
    use HasFactory, SoftDeletes;

    private $table = 'detail_pencairan_dana';
    private $primaryKey = 'id_detail_pencairan_dana';
    private $fillable = [
        'id_pencairan_dana',
        'id_detail_pengajuan_dana',
        'jumlah_pencairan'
    ];

    public function pencairan_dana(): HasOne
    {
        return $this->hasOne(PencairanDana::class, 'id_pencairan_dana', 'id_pencairan_dana');
    }

    public function detail_pengajuan_dana(): HasOne
    {
        return $this->hasOne(DetailPengajuanDana::class, 'id_detail_pengajuan_dana', 'id_detail_pengajuan_dana');
    }
}
