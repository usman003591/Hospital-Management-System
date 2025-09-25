<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\MedicineInventoryStatus;
use App\Models\UserPreferences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicineInventoryStatusesController extends Controller
{
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_medicine_inventory_status_45')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_inventory_statuses.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new MedicineInventoryStatus();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new MedicineInventoryStatus();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_medicine_inventory_status_45')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.medicine_inventory_statuses.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_medicine_inventory_status_45')) {
               return ErrorMessage(403);
        }
        $obj = MedicineInventoryStatus::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.medicine_inventory_statuses.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_medicine_inventory_status_45')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = MedicineInventoryStatus::find($id);
            return $obj->deleteObj();
        }
    }
}
