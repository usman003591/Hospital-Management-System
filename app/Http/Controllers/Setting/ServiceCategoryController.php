<?php

namespace App\Http\Controllers\Setting;

use App\Exports\DataExport;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\UserPreferences;
use Illuminate\Support\Facades\DB;
use App\Models\Hospital;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class ServiceCategoryController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_service_categories_11')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        $serviceCategories = ServiceCategory::getParentServiceCategories();
        $hospitals = Hospital::getActiveHospitals();

        return view('modules.service_categories.create', compact('preferences', 'serviceCategories','hospitals'));
    }

    public function store()
    {
        $obj = new ServiceCategory();
        return $obj->addForm();
    }

    public function update($id)
    {
        $obj = ServiceCategory::findOrFail($id);
        return $obj->updateForm($id);
    }

    public function index(Request $request)
    {
     if(!checkPersonPermission('list_service_categories_11')) {
               return ErrorMessage(403);
        }
   
    $preferences = UserPreferences::getPreferences();

    return view('modules.service_categories.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_service_categories_11')) {
               return ErrorMessage(403);
        }
        $obj = ServiceCategory::findOrFail($id);
        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::getActiveHospitals();
        $serviceCategories = ServiceCategory::getParentServiceCategories();

        return view('modules.service_categories.update', compact('preferences', 'obj', 'serviceCategories','hospitals'));
    }

    public function delete($id)
    {
         if(!checkPersonPermission('delete_service_categories_11')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = ServiceCategory::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }

    public function export () {
        try {

         $modelName = 'ServiceCategory'; $schema = 'service_categories';
         return Excel::download(new DataExport($modelName), $schema . '.xlsx');

         } catch (Exception $e) {
             $response = $e->getMessage();
             session()->flash('error',$response);
             return Redirect::route($schema.'.index');
         }
       }

    // public function fetchComplaints(Request $request)
    // {
    //     if ($request->complaint_id) {
    //         $complaint_id = $request->complaint_id;
    //         $data = ServiceCategory::where("parent_id", $complaint_id)->get(["name", "id"]);
    //         return response()->json($data);
    //     }
    // }

}
