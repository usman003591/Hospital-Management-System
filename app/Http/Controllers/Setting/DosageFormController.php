<?php

namespace App\Http\Controllers\Setting;

use App\Models\DosageForm;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class DosageFormController extends Controller
{
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_dosage_forms_32')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.dosage_forms.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new DosageForm();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new DosageForm();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        
         if(!checkPersonPermission('list_dosage_forms_32')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.dosage_forms.index', compact('preferences'));
    }

    public function edit($id)
    {
        
         if(!checkPersonPermission('update_dosage_forms_32')) {
               return ErrorMessage(403);
        }
        $obj = DosageForm::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.dosage_forms.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        
         if(!checkPersonPermission('delete_dosage_forms_32')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = DosageForm::find($id);
            return $obj->deleteObj();
        }
    }
}
