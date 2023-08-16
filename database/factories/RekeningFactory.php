<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rekening>
 */
class RekeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tujuan_rekening = ['Penerimaan Invoice', 'Daftar Rekening Keluar'];
        $random_tujuan_rekening_key = array_rand($tujuan_rekening);

        $bank = ['BCA', 'BTN', 'BSI', 'Mandiri', 'BRI'];
        $random_bank_key = array_rand($bank);

        $nama = fake()->name;

        return [
            'nama' => $nama,
            'jabatan' => fake()->jobTitle,
            'nama_bank' => $bank[$random_bank_key],
            'nomor_rekening' => fake()->bankAccountNumber,
            'nama_rekening' => $nama,
            'tujuan_rekening' => $tujuan_rekening[$random_tujuan_rekening_key]
        ];
    }
}
