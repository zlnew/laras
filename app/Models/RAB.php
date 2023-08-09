<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RAB extends Model
{
    use HasFactory, SoftDeletes, HasUlids;

    protected $table = 'rab';
    protected $primaryKey = 'id_rab';
    protected $fillable = [
        'tax',
        'additional_tax',
        'status_rab',
        'status_aktivitas',
        'id_proyek'
    ];
    
    public $autoIncrement = false;
}
