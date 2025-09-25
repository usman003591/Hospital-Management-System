<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class DataImport implements ToModel
{
    protected $data;
    protected $model;

    function __construct($model,$data) {
        $this->model = $model;
        $this->data = $data;
    }

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $modelName = '\\App\\Models\\'.$this->model;
        $importValues = array();

        $i = 0;
        foreach ($this->data as $x => $y) {
            $importValues[$x] = $row[$i];
            $i++;
        }

        return new $modelName($importValues);
    }
}
