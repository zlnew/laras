<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'timeline';
    protected $primaryKey = 'id_timeline';
    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'catatan',
        'status_aktivitas',
    ];
}
