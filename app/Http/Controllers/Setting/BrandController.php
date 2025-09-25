<?php

namespace App\Http\Controllers\Setting;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function create(Request $request)
    {
           if(!checkPersonPermission('create_brands_17')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.brands.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Brand();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Brand();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_brands_17')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.brands.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_brands_17')) {
               return ErrorMessage(403);
        }
        $obj = Brand::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.brands.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_brands_17')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Brand::find($id);
            return $obj->deleteObj();
        }
    }
}
