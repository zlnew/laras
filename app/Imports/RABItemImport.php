<?php

namespace App\Imports;

use App\Models\DetailRAB;
use App\Models\Satuan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RABItemImport implements ToModel, WithHeadingRow
{
    private $id_rab;

    public function __construct(string $id_rab) 
    {
        $this->id_rab = $id_rab;
    }

    public function model(array $row)
    {
        $satuan = Satuan::where('nama_satuan', $row['satuan'])->first();

        return new DetailRAB([
            'id_rab' => $this->id_rab,
            'uraian' => $row['uraian'],
            'id_satuan' => $satuan?->id_satuan,
            'volume' => $row['volume'],
            'harga_satuan' => $row['harga_satuan'],
            'keterangan' => $row['keterangan'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
