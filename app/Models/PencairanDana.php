<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PencairanDana extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    private $table = 'pencairan_dana';
    private $primaryKey = 'id_pencairan_dana';
    private $fillable = [
        'id_pengajuan_dana',
        'status_pencairan'
    ];
    public $autoIncrement = false;

    public function pengajuan_dana(): HasOne
    {
        return $this->hasOne(PengajuanDana::class, 'id_pengajuan_dana', 'id_pengajuan_dana');
    }
}
