<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRAB extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_rab';
    protected $primaryKey = 'id_detail_rab';
    protected $fillable = [
        'uraian',
        'volume',
        'harga_satuan',
        'keterangan',
        'id_rab',
        'id_satuan'
    ];
}
