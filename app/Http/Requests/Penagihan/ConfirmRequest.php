<?php

namespace App\Http\Requests\Penagihan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ConfirmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $totalPenagihan = DB::table('detail_penagihan')
          ->where('deleted_at', null)
          ->sum(DB::raw('volume_penagihan * harga_satuan_penagihan'));
          
        return [
            'jumlah_diterima' => ['nullable', 'numeric', 'min:1', "max:$totalPenagihan"],
        ];
    }
}
