<?php

namespace App\Http\Requests\PencairanDana;

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
            'id_detail_pengajuan_dana' => 'Uraian Pengajuan Dana'
        ];
    }

    public function rules(): array
    {
        return [
            'id_detail_pengajuan_dana' => ['required', 'exists:detail_pengajuan_dana,id_detail_pengajuan_dana'],
            'jumlah_pencairan' => ['required', 'numeric', 'min:1'],
        ];
    }
}
