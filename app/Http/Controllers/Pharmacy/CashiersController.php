<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Cashier;
use App\Models\UserPreferences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashiersController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_pharmacy_cashiers_43')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.cashiers.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Cashier();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Cashier();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
           if(!checkPersonPermission('list_pharmacy_cashiers_43')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.cashiers.index', compact('preferences'));
    }

    public function edit($id)
    {
           if(!checkPersonPermission('update_pharmacy_cashiers_43')) {
               return ErrorMessage(403);
        }
        $obj = Cashier::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.cashiers.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
           if(!checkPersonPermission('delete_pharmacy_cashiers_43')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Cashier::find($id);
            return $obj->deleteObj();
        }
    }
}
