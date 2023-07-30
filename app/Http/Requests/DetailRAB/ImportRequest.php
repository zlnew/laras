<?php

namespace App\Http\Requests\DetailRAB;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', File::types(['csv', 'xlsx'])]
        ];
    }
}
