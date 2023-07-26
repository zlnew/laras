<?php

namespace App\Http\Requests\Proyek;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'id_rekening' => 'rekening'
        ];
    }

    public function rules(): array
    {
        return [
            'nama_proyek' => ['required', 'string', 'max:255'],
            'tahun_anggaran' => ['required', 'string', 'max:15'],
            'pengguna_jasa' => ['required', 'string', 'max:50'],
            'nilai_kontrak' => ['required', 'numeric', 'min:1'],
            'waktu_mulai' => ['required', 'date'],
            'durasi' => ['required', 'numeric', 'min:1'],
            'waktu_selesai' => ['required', 'date'],
            'pic' => ['required', 'string', 'max:50'],
            'id_rekening' => ['required', 'exists:rekening,id_rekening']
        ];
    }
}
