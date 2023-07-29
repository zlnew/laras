<?php

namespace App\Http\Requests\RAP;

use App\Models\RAP;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'id_proyek' => 'proyek'
        ];
    }

    public function rules(): array
    {
        return [
            'id_proyek' => ['required', Rule::unique(RAP::class, 'id_proyek')->ignore($this->id_rap, 'id_rap')],
        ];
    }
}
