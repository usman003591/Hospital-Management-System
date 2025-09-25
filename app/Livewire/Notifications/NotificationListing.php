<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use App\Models\Hospital;
use App\Models\Notification;
use Livewire\WithPagination;
use App\Models\UserPreferences;

class NotificationListing extends Component
{
    use WithPagination;

    public $q = '';
     public $status = '';
    protected $paginationTheme = 'bootstrap';
    
    protected $queryString = [
        'q' => ['except' => ''],
        'status' => ['except' => ''],
    ];


    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q','status']);
        $this->resetPage();
    }

    public function render()
    {
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $data = Notification::query()
            ->join('hospitals as h', 'h.id', '=', 'notifications.hospital_id')
         
          
            ->select(
                'notifications.*',
                'h.name as hospital_name',
            )
            ->where('h.id', $hospital_id)
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('notifications.name', 'ILIKE', "%{$this->q}%")
                    ->orWhere('notifications.notification_slug', 'ILIKE', "%{$this->q}%")
                     ->orWhere('notifications.description', 'ILIKE', "%{$this->q}%");
                });
            })
             ->when($this->status !== '', function ($query) {
        $query->where('notifications.status', $this->status);
    })
            ->orderBy('notifications.created_at', 'desc')
            ->paginate(10);

        return view('livewire.notifications.notifications-listing', [
            'data' => $data,
            'page' => 'notifications',
            'hospitals' => $hospitals
        ]);
    }
}