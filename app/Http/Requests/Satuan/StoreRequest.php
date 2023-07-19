<?php

namespace App\Http\Requests\Satuan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'nama_satuan' => ['required', 'string', 'unique:satuan,nama_satuan', 'max:255']
        ];
    }
}
