<?php

namespace App\Http\Requests\Penagihan;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'potongan_ppn' => ['nullable', 'numeric'],
            'potongan_pph' => ['nullable', 'numeric'],
            'potongan_lainnya' => ['nullable', 'numeric'],
            'keterangan_potongan_lainnya' => ['nullable', 'string', 'max:255'],
        ];
    }
}
