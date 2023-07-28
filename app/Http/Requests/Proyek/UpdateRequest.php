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
            'id_user' => 'penanggung jawab',
            'id_rekening' => 'rekening'
        ];
    }

    public function rules(): array
    {
        return [
            'nama_proyek' => ['required', 'string', 'max:255'],
            'nomor_kontrak' => ['required', 'string', 'max:25'],
            'tanggal_kontrak' => ['required', 'date'],
            'pengguna_jasa' => ['required', 'string', 'max:128'],
            'penyedia_jasa' => ['required', 'string', 'max:128'],
            'tahun_anggaran' => ['required', 'numeric', 'digits:4'],
            'nomor_spmk' => ['required', 'string', 'max:255'],
            'tanggal_spmk' => ['required', 'date'],
            'nilai_kontrak' => ['required', 'numeric', 'min:1'],
            'tanggal_mulai' => ['required', 'date'],
            'durasi' => ['required', 'numeric', 'min:1'],
            'tanggal_selesai' => ['required', 'date'],
            'id_user' => ['required', 'exists:users,id'],
            'id_rekening' => ['required', 'exists:rekening,id_rekening']
        ];
    }
}
