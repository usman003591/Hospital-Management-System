<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    protected $listeners = ['notificationUpdated' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->unreadCount = NotificationUser::where('notification_receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $this->notifications = NotificationUser::where('notification_receiver_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();
    }

    public function markAsRead($id)
    {
        $notification = NotificationUser::where('id', $id)
            ->where('notification_receiver_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
            $this->loadNotifications();

            // Optionally emit event for other components (like a global badge)
            $this->dispatch('notificationUpdated');
        }
    }

    public function render()
    {
        return view('livewire.notifications.notifications-dropdown');
    }
}
