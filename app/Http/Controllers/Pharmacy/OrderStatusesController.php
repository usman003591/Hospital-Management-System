<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\OrderStatus;
use App\Models\UserPreferences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusesController extends Controller
{
    public function create(Request $request)
    {
         if(!checkPersonPermission('create_order_status_47')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.order_statuses.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new OrderStatus();
        return $obj->addForm();
    }

    public function update(Request $request)
    {
        $obj = new OrderStatus();
        return $obj->updateForm();
    }

    public function index(Request $request)
    {
         if(!checkPersonPermission('list_order_status_47')) {
               return ErrorMessage(403);
        }
        
        $preferences = UserPreferences::getPreferences();
        return view('modules.order_statuses.index', compact('preferences'));
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_order_status_47')) {
               return ErrorMessage(403);
        }
        $obj = OrderStatus::find($id);
        $preferences = UserPreferences::getPreferences();

        return view('modules.order_statuses.update', compact('preferences', 'obj'));
    }

    public function delete($id = false)
    {
         if(!checkPersonPermission('delete_order_status_47')) {
               return ErrorMessage(403);
        }
        if ($id) {
            $obj = OrderStatus::find($id);
            return $obj->deleteObj();
        }
    }
}
