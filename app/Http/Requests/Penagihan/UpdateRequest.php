<?php

namespace App\Http\Requests\Penagihan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_proyek' => ['required', 'exists:proyek,id_proyek'],
            'id_rekening' => ['required', 'exists:rekening,id_rekening'],
            'keperluan' => ['required', 'string', 'max:255'],
            'nomor_sp2d' => ['required', 'string', 'max:255'],
            'tanggal_sp2d' => ['required', 'date'],
            'tanggal_terbit' => ['required', 'date'],
            'tanggal_cair' => ['required', 'date'],
            'nilai_netto' => ['required', 'numeric', 'min:1'],
            'faktur' => [
                'nullable',
                File::types(['png', 'jpg', 'jpeg', 'pdf'])
                    ->max(100)
            ]
        ];
    }
}
