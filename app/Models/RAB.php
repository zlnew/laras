<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RAB extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'rab';
    protected $primaryKey = 'id_rab';
    protected $fillable = [
        'id_proyek',
        'tax',
        'additional_tax',
    ];
    public $autoIncrement = false;

    public function proyek(): HasOne
    {
        return $this->hasOne(Proyek::class, 'id_proyek', 'id_proyek');
    }

    public function uraian(): HasMany
    {
        return $this->hasMany(DetailRAB::class, 'id_rab', 'id_rab');
    }
}
