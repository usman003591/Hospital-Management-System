<?php

namespace App\Http\Controllers\Setting;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;
use App\Models\MedicineRoute;

class MedicineRoutesController extends Controller
{
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_medicine_routes_19')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_routes.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new MedicineRoute();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new MedicineRoute();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_medicine_routes_19')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_routes.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_medicine_routes_19')) {
               return ErrorMessage(403);
        }
        $obj = MedicineRoute::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.medicine_routes.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_medicine_routes_19')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = MedicineRoute::find($id);
            return $obj->deleteObj();
        }
    }
}
