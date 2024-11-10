<?php

namespace App\Imports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new student([
            //
            'no_id' => $row[1],
            'name' => $row[2],
            'class'=>$row[3],
            'majority'=>$row[4]
        ]);
    }
}
