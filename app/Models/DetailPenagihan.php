<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_penagihan';
    protected $primaryKey = 'id_detail_penagihan';
    protected $fillable = [
        'volume_penagihan',
        'harga_satuan_penagihan',
        'status_diterima',
        'id_penagihan',
        'id_detail_rab'
    ];
}
