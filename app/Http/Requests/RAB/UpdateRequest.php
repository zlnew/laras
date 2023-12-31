<?php

namespace App\Http\Requests\RAB;

use App\Models\RAB;
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
            'id_proyek' => ['required', Rule::unique(RAB::class, 'id_proyek')->ignore($this->id_rab, 'id_rab')],
        ];
    }
}
