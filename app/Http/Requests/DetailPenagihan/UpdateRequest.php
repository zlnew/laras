<?php

namespace App\Http\Requests\DetailPenagihan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'id_detail_rab' => ['required', 'exists:detail_rab,id_detail_rab'],
            'volume_penagihan' => ['required', 'numeric', 'min:1'],
            'harga_satuan_penagihan' => ['required', 'numeric', 'min:1']
        ];
    }
}
