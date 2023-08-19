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
            ->where('id_penagihan', $this->id_penagihan)
            ->selectRaw('SUM(CAST(volume_penagihan * harga_satuan_penagihan AS DECIMAL(20, 2))) as total')
            ->first();
          
        return [
            'jumlah_diterima' => ['required_if:bertahap,true', 'numeric', 'min:1', "max:$totalPenagihan->total"],
        ];
    }
}
