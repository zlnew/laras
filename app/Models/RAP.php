<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RAP extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'rap';
    protected $primaryKey = 'id_rap';
    protected $fillable = [
        'id_proyek',
        'status_rap'
    ];
    public $autoIncrement = false;

    public function proyek(): HasOne
    {
        return $this->hasOne(Proyek::class, 'id_proyek', 'id_proyek');
    }

    public function uraian(): HasMany
    {
        return $this->hasMany(DetailRAP::class, 'id_rap', 'id_rap');
    }
}
