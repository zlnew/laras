<?php

namespace App\Http\Requests\DetailRAB;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function attributes(): array
    {
        return [
            'id_satuan' => 'satuan',
        ];
    }

    public function rules(): array
    {
        return [
            'id_satuan' => ['required', 'exists:satuan,id_satuan'],
            'uraian' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'numeric', 'min:1', 'max:999'],
            'harga_satuan' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
