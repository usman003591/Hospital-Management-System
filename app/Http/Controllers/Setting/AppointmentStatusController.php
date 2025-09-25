<?php

namespace App\Http\Controllers\Setting;

use App\Models\AppointmentStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserPreferences;

class AppointmentStatusController extends Controller
{
    public function index(Request $request)
    {
         if(!checkPersonPermission('list_appointment_statuses_30')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();

        return view('modules.appointment_statuses.index', compact('preferences'));
    }

    public function create()
    {
         if(!checkPersonPermission('create_appointment_statuses_30')) {
               return ErrorMessage(403);
        }
        $preferences = UserPreferences::getPreferences();
        return view('modules.appointment_statuses.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        $appointmentStatus = new AppointmentStatus();
        $result = $appointmentStatus->addForm($request);

        if ($result) {
            return redirect()->route('appointment_statuses.index')->with('success', 'Appointment status created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create appointment status.');
    }

    public function edit($id)
    {
         if(!checkPersonPermission('update_appointment_statuses_30')) {
               return ErrorMessage(403);
        }
        $status = AppointmentStatus::findOrFail($id);
        $preferences = UserPreferences::getPreferences();
        return view('modules.appointment_statuses.update', compact('preferences', 'status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        $status = AppointmentStatus::findOrFail($id);
        $result = $status->updateForm($request);

        if ($result) {
            return redirect()->route('appointment_statuses.index')->with('success', 'Appointment status updated successfully.');
        }

        return redirect()->back()->with('error', 'Failed to update appointment status.');
    }

   
    public function delete($id)
{
     if(!checkPersonPermission('delete_appointment_statuses_30')) {
               return ErrorMessage(403);
        }
    $status = AppointmentStatus::find($id); 

    if ($status) {
        $status->update(['deleted_by' => auth()->id()]);
        $status->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Appointment status deleted successfully.',
        ]);
    }

    return response()->json([
        'status' => 500,
        'message' => 'Failed to delete appointment status.',
    ]);
}

}
