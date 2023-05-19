<?php

namespace App\Imports;

use App\Models\Picking;
use Maatwebsite\Excel\Concerns\ToModel;

class PickingsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Picking([
            'name'     => $row[0],
            'reference'    => $row[1], 
            'qty' => $row[2],
        ]);
    }
}
