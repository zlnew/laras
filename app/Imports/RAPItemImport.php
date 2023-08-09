<?php

namespace App\Imports;

use App\Models\DetailRAP;
use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RAPItemImport implements ToModel, WithHeadingRow
{
    private $id_rap;

    public function __construct(string $id_rap) 
    {
        $this->id_rap = $id_rap;
    }

    public function model(array $row)
    {
        $satuan = Satuan::where('nama_satuan', $row['satuan'])->first();

        return new DetailRAP([
            'id_rap' => $this->id_rap,
            'uraian' => $row['uraian'],
            'id_satuan' => $satuan?->id_satuan,
            'volume' => $row['volume'],
            'harga_satuan' => $row['harga_satuan'],
            'status_uraian' => $row['status'],
            'keterangan' => $row['keterangan'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
