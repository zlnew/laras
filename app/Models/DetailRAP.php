<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRAP extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_rap';
    protected $primaryKey = 'id_detail_rap';
    protected $fillable = [
        'uraian',
        'volume',
        'harga_satuan',
        'status_uraian',
        'keterangan',
        'id_rap',
        'id_satuan'
    ];
}