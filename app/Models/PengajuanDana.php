<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanDana extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'pengajuan_dana';
    protected $primaryKey = 'id_pengajuan_dana';
    protected $fillable = [
        'id_rap',
        'keterangan',
        'status_pengajuan',
    ];
    public $autoIncrement = false;

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPengajuanDana::class, 'id_pengajuan_dana', 'id_pengajuan_dana');
    }

    public function rap(): HasOne
    {
        return $this->hasOne(RAP::class, 'id_rap', 'id_rap');
    }
}
