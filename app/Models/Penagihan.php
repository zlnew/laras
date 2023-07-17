<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penagihan extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'penagihan';
    protected $primaryKey = 'id_penagihan';
    protected $fillable = [
        'id_keuangan',
        'status_penagihan',
        'status_aktivitas'
    ];

    public $autoIncrement = false;
}
