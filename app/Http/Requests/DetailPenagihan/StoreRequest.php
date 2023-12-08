<?php

namespace App\Http\Requests\DetailPenagihan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'id_detail_rab' => 'Uraian RAB'
        ];
    }

    public function rules(): array
    {
        return [
            'uraian' => ['required', 'string', 'max:255'],
            'volume_penagihan' => ['required', 'numeric', 'min:0.1'],
            'harga_satuan_penagihan' => ['required', 'numeric', 'min:1']
        ];
    }
}
