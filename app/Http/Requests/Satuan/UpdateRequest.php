<?php

namespace App\Http\Requests\Satuan;

use App\Models\Satuan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_satuan' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Satuan::class, 'nama_satuan')->ignore($this->id_satuan, 'id_satuan')
            ]
        ];
    }
}
