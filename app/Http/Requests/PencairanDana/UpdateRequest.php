<?php

namespace App\Http\Requests\PencairanDana;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_detail_pengajuan_dana' => ['required', 'exists:detail_pengajuan_dana,id_detail_pengajuan_dana'],
            'jumlah_pencairan' => ['required', 'numeric', 'min:1'],
        ];
    }
}
