<?php

namespace App\Http\Requests\Proyek;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'waktu_mulai' => 'tanggal mulai',
            'waktu_selesai' => 'tanggal selesai',
            'pic' => 'penanggung jawab',
        ];
    }

    public function rules(): array
    {
        return [
            'nama_proyek' => ['required', 'string', 'max:255'],
            'tahun_anggaran' => ['required', 'string', 'max:15'],
            'pengguna_jasa' => ['required', 'string', 'max:50'],
            'nilai_kontrak' => ['required', 'numeric'],
            'waktu_mulai' => ['required', 'date'],
            'waktu_selesai' => ['required', 'date'],
            'pic' => ['required', 'string', 'max:50'],
        ];
    }
}
