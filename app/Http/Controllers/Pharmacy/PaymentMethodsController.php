<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\PaymentMethod;
use App\Models\UserPreferences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMethodsController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_payment_methods_46')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.payment_methods.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new PaymentMethod();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new PaymentMethod();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_payment_methods_46')) {
               return ErrorMessage(403);
        }
       
        $preferences = UserPreferences::getPreferences();
        return view('modules.payment_methods.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_payment_methods_46')) {
               return ErrorMessage(403);
        }
        $obj = PaymentMethod::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.payment_methods.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_payment_methods_46')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = PaymentMethod::find($id);
            return $obj->deleteObj();
        }
    }
}
