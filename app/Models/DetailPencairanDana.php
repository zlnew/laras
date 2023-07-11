<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPencairanDana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_pencairan_dana';
    protected $primaryKey = 'id_detail_pencairan_dana';
    protected $fillable = [
        'id_pencairan_dana',
        'id_detail_pengajuan_dana',
        'jumlah_pencairan'
    ];
}
