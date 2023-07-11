<?php

namespace App\Http\Requests\DetailRAP;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Set the attributes for the request
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'id_satuan' => 'satuan',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_satuan' => ['required', 'exists:satuan,id_satuan'],
            'uraian' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'numeric', 'min:1', 'max:999'],
            'harga_satuan' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'status_uraian' => ['required', 'string'],
        ];
    }
}
