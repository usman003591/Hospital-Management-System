<?php

namespace App\Http\Controllers\Setting;

use App\Models\Floor;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class FloorController extends Controller
{
    public function create(Request $request)
    {
        
         if(!checkPersonPermission('create_floors_34')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.floors.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Floor();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Floor();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
          
      if(!checkPersonPermission('list_floors_34')) {
               return ErrorMessage(403);
        }
       
        $preferences = UserPreferences::getPreferences();
        return view('modules.floors.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_floors_34')) {
               return ErrorMessage(403);
        }
        $obj = Floor::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.floors.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_floors_34')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Floor::find($id);
            return $obj->deleteObj();
        }
    }
}
