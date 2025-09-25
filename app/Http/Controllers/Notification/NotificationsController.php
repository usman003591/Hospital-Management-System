<?php

namespace App\Http\Controllers\Notification;

use App\Models\Notification;
use App\Models\NotificationCategory;
use App\Models\Hospital;
use App\Models\UserPreferences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
    
        $page = 'notifications';
        $result = Notification::getAll();
        $data = $result['data'];
        $search = $result['search'];
        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::getActiveHospitals();
        $categories = NotificationCategory::where('status', 1)->get();

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.notifications.include.list_partial', compact('data', 'page', 'search', 'categories'))->render(),
            ]);
        }

        return view('modules.notifications.index', compact('data', 'page', 'search', 'preferences','hospitals', 'categories'));
    }

    public function create()
    {
    

        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::getActiveHospitals();
        $categories = NotificationCategory::where('status', 1)->get();

        return view('modules.notifications.create', compact('preferences', 'categories','hospitals'));
    }

    public function store(Request $request)
    {

        $obj = new Notification();
        return $obj->addForm($request);
    }

    public function edit($id)
    {
        
        $obj = Notification::findOrFail($id);
        $preferences = UserPreferences::getPreferences();
        $hospitals = Hospital::getActiveHospitals();
        $categories = NotificationCategory::where('status', 1)->get();

        return view('modules.notifications.update', compact('obj','hospitals', 'preferences', 'categories'));
    }

    public function update(Request $request)
    {
       
        $obj = new Notification();
        return $obj->updateForm($request);
    }

    public function delete($id = false)
    {
        if ($id) {
            $obj = Notification::findOrFail($id);
            return $obj->deleteObj();
        }

        return response()->json(['status' => 404, 'message' => 'Invalid ID']);
    }
}

