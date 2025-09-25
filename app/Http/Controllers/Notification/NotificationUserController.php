<?php
namespace App\Http\Controllers\Notification;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\NotificationUser;
use App\Http\Controllers\Controller;


class NotificationUserController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $notifications = NotificationUser::where('notification_receiver_id', $user_id)
        ->latest()
        ->paginate(20);
        $preferences = UserPreferences::getPreferences();

        // dd($notifications);
        return view('modules.notifications.view', compact('notifications', 'preferences'));
    }

    // public function markAsRead($id)
    // {
    //     $notification = NotificationUser::findOrFail($id);

    //     if ($notification->notification_receiver_id == auth()->id()) {
    //         $notification->update([
    //             'is_read' => true,
    //             'viewed_at' => now()
    //         ]);
    //     }

    //     return back();
    // }
}
