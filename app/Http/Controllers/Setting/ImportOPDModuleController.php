<?php

namespace App\Http\Controllers\Setting;

use Exception;
use App\Models\Brand;
use App\Models\Medicines;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Imports\MedicinesImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ImportOPDModuleController extends Controller
{
    public function import (Request $request) {
          if(!checkPersonPermission('list_import_data_29')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.import_data.index', compact('preferences'));
    }

    public function import_opd_complaints (Request $request) {
        try {
            $request->validate([
                'file'=>'required|max:2000|mimes:xlsx,csv'
            ]);

            $schema = 'complaints'; $modelName = 'Complaint';
            $msg = 'Complaints';
            DB::table('complaints')->truncate();
            $data = getModelImportData($modelName);

            $excel = Excel::import(new DataImport($modelName,$data), $request->file);

            session()->flash('success', $msg .' imported successfully');
            return Redirect::route($schema.'.index');

            } catch (Exception $e) {
                $response = $e->getMessage();
                session()->flash('error',$response);
                return Redirect::route($schema.'.index');
            }
    }

    public function import_opd_gpe (Request $request) {
        try {
            $request->validate([
                'file'=>'required|max:2000|mimes:xlsx,csv'
            ]);

            $schema = 'general_physical_examinations'; $modelName = 'GeneralPhysicalExamination';
            $msg = 'GPE';
            DB::table('general_physical_examinations')->truncate();
            $data = getModelImportData($modelName);

            $excel = Excel::import(new DataImport($modelName,$data), $request->file);

            session()->flash('success', $msg .' imported successfully');
            return Redirect::route($schema.'.index');

            } catch (Exception $e) {
                $response = $e->getMessage();
                session()->flash('error',$response);
                return Redirect::route($schema.'.index');
            }
    }

    public function import_opd_spe (Request $request) {
        try {
            $request->validate([
                'file'=>'required|max:2000|mimes:xlsx,csv'
            ]);

            $schema = 'systematic_physical_examinations'; $modelName = 'SystematicPhysicalExamination';
            $msg = 'SPE';
            DB::table('systematic_physical_examinations')->truncate();
            $data = getModelImportData($modelName);

            $excel = Excel::import(new DataImport($modelName,$data), $request->file);

            session()->flash('success', $msg .' imported successfully');
            return Redirect::route($schema.'.index');

            } catch (Exception $e) {
                $response = $e->getMessage();
                session()->flash('error',$response);
                return Redirect::route($schema.'.index');
            }
    }

    public function import_opd_investigations (Request $request) {
        try {
            $request->validate([
                'file'=>'required|max:2000|mimes:xlsx,csv'
            ]);

            $schema = 'investigations'; $modelName = 'Investigations';
            DB::table('investigations')->truncate();
            $data = getModelImportData($modelName);
            $excel = Excel::import(new DataImport($modelName,$data), $request->file);

            session()->flash('success', $schema .' imported successfully');
            return Redirect::route($schema.'.index');

            } catch (Exception $e) {
                $response = $e->getMessage();
                session()->flash('error',$response);
                return Redirect::route($schema.'.index');
            }
    }

    public function import_opd_diagnosis (Request $request) {
        try {
            // $request->validate([
            //     'file'=>'required|mimes:xlsx,csv'
            // ]);

            $schema = 'diagnosis'; $modelName = 'Diagnosis';
            $msg= 'Diagnosis';
            //DB::table('diagnosis')->truncate();

            $data = getModelImportData($modelName);
            $excel = Excel::import(new DataImport($modelName,$data), $request->file);

            session()->flash('success', $msg .' imported successfully');
            return Redirect::route('diagnosis.index');

            } catch (Exception $e) {
                $response = $e->getMessage();
                session()->flash('error',$response);
                return Redirect::route('diagnosis.index');
            }
    }


      public function import_medical_camp_data (Request $request) {
        try {

            $schema = 'medicines'; $modelName = 'Medicines';
            $msg= 'Medicines';

            Excel::import(new MedicinesImport, $request->file);

            session()->flash('success', $msg .' imported successfully');
            return Redirect::route('medicines.index');

            } catch (Exception $e) {
                $response = $e->getMessage();
                session()->flash('error',$response);
                return Redirect::route('medicines.index');
            }
    }

    public function import_opd_treatment (Request $request) {
        // try {
        //     $request->validate([
        //         'file'=>'required|max:2000|mimes:xlsx,csv'
        //     ]);

        //     $schema = 'medicines'; $modelName = 'Medicines';
        //     $msg= 'Medicines';
        //     DB::table('medicines')->truncate();
        //     $data = getModelImportData($modelName);

        //     $excel = Excel::import(new DataImport($modelName,$data), $request->file);

        //     session()->flash('success', $msg .' imported successfully');
        //     return Redirect::route($schema.'.index');

        //     } catch (Exception $e) {
        //         $response = $e->getMessage();
        //         session()->flash('error',$response);
        //         return Redirect::route($schema.'.index');
        //     }

        try {
            $request->validate([
                'file' => 'required|max:2000|mimes:xlsx,csv'
            ]);

            $schema = 'medicines';
            //DB::table('medicines')->truncate();

            Excel::import(new class implements ToArray {
                public function array(array $rows)
                {
                    // Remove the header row (assumed to be the first row)
                    $dataRows = array_slice($rows, 1);

                    foreach ($dataRows as $rowIndex => $row) {
                        $data = [
                            'Medicine Name' => $row[0] ?? null,
                            'full name' => $row[1] ?? null,
                            'Brand' => $row[2] ?? null,
                            'Price' => $row[4] ?? null, // Adjust index if needed
                        ];

                        if (empty($data['Medicine Name'])) {
                            throw new Exception("The name field is required for all rows. Error on row: " . ($rowIndex + 2)); // +2 to account for the skipped header
                        }

                        $brandData = Brand::where('brand_name', $data['Brand'])->first();
                        if ($brandData) {
                            $brandId = $brandData->id;
                        } else {
                            $newBrand = Brand::create([
                                'brand_name' => $data['Brand'] ?? 'Unknown',
                                'status' => 1,
                            ]);
                            $brandId = $newBrand->id;
                        }

                        Medicines::create([
                            'brand_id' => $brandId,
                            'name' => $data['full name'],
                            'short_name' => $data['Medicine Name'],
                            'cost' => $data['Price'],
                            'status' => 1,
                            'created_by' => auth()->user()->id ?? 1,
                        ]);
                    }
                }
            }, $request->file);


            session()->flash('success', 'Medicines imported successfully');
            return redirect()->route($schema . '.index');

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route($schema . '.index');
        }
    }

}
