<?php

namespace App\Http\Requests\PengajuanDana;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'id_proyek' => 'proyek',
        ];
    }

    public function rules(): array
    {
        return [
            'id_proyek' => ['required', 'exists:proyek,id_proyek'],
            'keperluan' => ['required', 'string', 'max:255'],
            'jenis_transaksi' => ['required', 'string']
        ];
    }
}
