<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;

class ViewAllNotifications extends Component
{
    use WithPagination;

    public $perPage = 20;

    protected $paginationTheme = 'bootstrap'; // so pagination looks like Metronic

    protected $listeners = ['notificationUpdated' => '$refresh'];

    public function changeStatus($id)
    {
        $notification = NotificationUser::findOrFail($id);

        if ($notification->notification_receiver_id === Auth::id()) {
            $notification->update([
                'is_read' => true,
                'viewed_at' => now()
            ]);
            $this->dispatch('notificationUpdated');
        }
    }
    public function render()
    {
        $notifications = NotificationUser::where('notification_receiver_id', Auth::id())
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.notifications.view-all-notifications', compact('notifications'));
    }
}
