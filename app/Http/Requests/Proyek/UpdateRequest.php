<?php

namespace App\Http\Requests\Proyek;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
            'waktu_mulai' => 'tanggal mulai',
            'waktu_selesai' => 'tanggal selesai',
            'pic' => 'penanggung jawab',
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
