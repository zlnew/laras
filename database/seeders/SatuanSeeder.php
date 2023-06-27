<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['Orang-Bulan', 'LS', 'Unit', 'Eksemplar', 'Unit-Bulan', 'Hari', 'Meter', 'Titik'];

        foreach ($units as $unit) {
            Satuan::create(['nama_satuan' => $unit]);
        }
    }
}
