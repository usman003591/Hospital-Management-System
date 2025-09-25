<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NotificationCategory;

class AllNotificationCategoriesListing extends Component
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
        $this->reset(['q', 'status']);
        $this->resetPage();
    }


    public function render()
    {

        $data = NotificationCategory::query();

        if ($this->q) {
            $data->where(function ($q) {
                $q->where('name', 'iLIKE', '%' . $this->q . '%');
      
            });
        }

        if ($this->status !== '') {
            $data->where('status', $this->status);
        }

        $data = $data->latest()->paginate(10);
      

        return view('livewire.notifications.all-notification-categories-listing', [
            'data' => $data,
            'page' => 'notification_categories',
        ]);
    }
}
