<?php

namespace App\Http\Controllers\Setting;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\RoleRightModules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class RolesController extends Controller
{
    public function create(Request $request)
    {
        if(!checkPersonPermission('create_roles_2')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.roles.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Role();
        return $obj->addForm($request);
    }

    public function update(Request $request)
    {
        $obj = Role::find($request->id);
        return $obj->updateForm($request);
    }

    public function index(Request $request)
    {
        
        if(!checkPersonPermission('list_roles_2')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.roles.index', compact('preferences'));
    }

    public function edit($id)
    {
        
        if(!checkPersonPermission('update_roles_2')) {
               return ErrorMessage(403);
        }
        $obj = Role::find($id);

        $preferences = UserPreferences::getPreferences();
        return view('modules.roles.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        
        if(!checkPersonPermission('delete_roles_2')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Role::find($id);
            return $obj->deleteObj();
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid ID provided.',
        ]);
    }

    public function permissions(Request $request, $id = false){
        
        if(!checkPersonPermission('permissions_roles_2')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        $id = intval($id);
        if($id) {
            $role = Role::getById($id);
            $module = RoleRightModules::getAllParents();
            if($role && $module)
                return view('modules.roles.permissions', compact('role', 'module','preferences'));
        }
    }

    public function permissions_update(Request $request, $id = false) {
        $id = intval($id);
        if($id) {
            $role = Role::getById($id);
            if($role) {
                $role->updatePermission($request->all());
            }
        }
    }

}
