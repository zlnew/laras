<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PencairanDana extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'pencairan_dana';
    protected $primaryKey = 'id_pencairan_dana';
    protected $fillable = [
        'id_keuangan',
        'status_pencairan',
        'status_aktivitas',
    ];
    public $autoIncrement = false;
}
