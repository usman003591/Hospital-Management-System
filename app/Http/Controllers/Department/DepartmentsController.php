<?php

namespace App\Http\Controllers\Department;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    public function create(Request $request)
    {
          if(!checkPersonPermission('create_departments_12')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.departments.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new Department();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new Department();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
        if(!checkPersonPermission('list_departments_12')) {
               return ErrorMessage(403);
        }

        $preferences = UserPreferences::getPreferences();
        return view('modules.departments.index', compact('preferences'));
    }

    public function edit($id)
    {
        if(!checkPersonPermission('update_departments_12')) {
               return ErrorMessage(403);
        }
        $obj = Department::find($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.departments.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
        if(!checkPersonPermission('delete_departments_12')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = Department::find($id);
            return $obj->deleteObj();
        }
    }
}
