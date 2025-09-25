<?php

namespace App\Http\Controllers\Pharmacy;

use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\MedicineCategory;
use App\Http\Controllers\Controller;

class MedicineCategoriesController extends Controller
{
    public function create(Request $request)
    {
           if(!checkPersonPermission('create_medicine_categories_44')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.medicine_categories.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new MedicineCategory();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new MedicineCategory();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_medicine_categories_44')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_categories.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_medicine_categories_44')) {
               return ErrorMessage(403);
        }
        $obj = MedicineCategory::find($id);
        $preferences = UserPreferences::getPreferences();


        return view('modules.medicine_categories.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_medicine_categories_44')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = MedicineCategory::find($id);
            return $obj->deleteObj();
        }
    }
}
