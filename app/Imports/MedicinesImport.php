<?php

namespace App\Imports;

use App\Models\Medicines;
use Maatwebsite\Excel\Concerns\ToModel;

class MedicinesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
           return new Medicines([
            'name'  => $row[0],
            'medicine_category_id' => $row[1],
            'is_in_house' => $row[2],
            'created_by' => $row[3],
            'short_name' => $row[4]
        ]);

    }
}




