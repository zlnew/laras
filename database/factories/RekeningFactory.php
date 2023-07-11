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
        return [
            'nama' => fake()->name,
            'jabatan' => fake()->jobTitle,
            'nama_bank' => fake()->word,
            'nomor_rekening' => fake()->bankAccountNumber,
            'nama_rekening' => fake()->name,
        ];
    }
}
