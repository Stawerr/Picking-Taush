<?php

namespace App\Imports;

use App\Models\Taush;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TaushesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Taush([
            'name'     => $row['Nome'],
            'reference'    => $row['Referencia'], 
        ]);
    }
}
