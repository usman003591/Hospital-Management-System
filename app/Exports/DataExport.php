<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    protected $model;

    function __construct($model) {
        $this->model = $model;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $modelName = '\\App\\Models\\'.$this->model;
        return $modelName::all();
    }
}
