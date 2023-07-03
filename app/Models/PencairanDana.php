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

    protected $table = 'pencairan_dana';
    protected $primaryKey = 'id_pencairan_dana';
    protected $fillable = [
        'id_pengajuan_dana',
        'keterangan',
        'status_pencairan'
    ];
    public $autoIncrement = false;

    public function pengajuan_dana(): HasOne
    {
        return $this->hasOne(PengajuanDana::class, 'id_pengajuan_dana', 'id_pengajuan_dana');
    }
}
