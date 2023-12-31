<?php

namespace App\Http\Requests\DetailPengajuanDana;

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
            'id_detail_rap' => 'uraian_rap',
            'id_rekening' => 'rekening',
        ];
    }

    public function rules(): array
    {
        return [
            'id_detail_rap' => ['required_if:kategori,Proyek'],
            'id_rekening' => ['required', 'exists:rekening,id_rekening'],
            'uraian' => ['required', 'string', 'max:255'],
            'jumlah_pengajuan' => ['required', 'numeric', 'min:1'],
            'jenis_pembayaran' => ['required', 'string'],
        ];
    }
}
