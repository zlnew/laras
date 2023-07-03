<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persetujuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'persetujuan';
    protected $primaryKey = 'id_persetujuan';
    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'catatan',
    ];
}
