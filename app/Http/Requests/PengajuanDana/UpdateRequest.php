<?php

namespace App\Http\Requests\PengajuanDana;

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
            'id_detail_rap' => ['required', 'exists:detail_rap,id_detail_rap'],
            'id_rekening' => ['required', 'exists:rekening,id_rekening'],
            'uraian' => ['required', 'string', 'max:255'],
            'jumlah_pengajuan' => ['required', 'numeric', 'min:1'],
            'jenis_pembayaran' => ['required', 'string'],
        ];
    }
}
