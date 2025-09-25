<?php

namespace App\Http\Controllers\Notification;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\NotificationCategory;
use App\Models\UserPreferences;

class NotificationCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $page = 'notification_categories';
        $result = NotificationCategory::getAll();
        $data = $result['data'];
        $search = $result['search'];
        $preferences = UserPreferences::getPreferences();

         if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'data' => view('modules.notification_categories.include.list_partial', compact('data', 'page', 'search'))->render(),
            ]);
        }

        return view('modules.notification_categories.index', compact('data', 'page', 'search', 'preferences'));
    }

    public function create()
    {
        $preferences = UserPreferences::getPreferences();
        return view('modules.notification_categories.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $obj = new NotificationCategory();
        return $obj->addForm($request);
    }

    public function edit($id)
    {
        $obj = NotificationCategory::findOrFail($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.notification_categories.update', compact('obj', 'preferences'));
    }

    public function update(Request $request)
    {
        $obj = new NotificationCategory();
        return $obj->updateForm($request);
    }

    public function delete($id)
    {
        if ($id) {
            $obj = NotificationCategory::findOrFail($id);
            return $obj->deleteObj();
        }

        return response()->json(['status' => 404, 'message' => 'Invalid ID']);
    }
}
