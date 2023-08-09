<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekening extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'rekening';
    protected $primaryKey = 'id_rekening';
    protected $fillable = [
        'nama',
        'jabatan',
        'nama_bank',
        'nomor_rekening',
        'nama_rekening',
        'tujuan_rekening'
    ];
    
    public $autoIncrement = false;
}
