<?php

namespace App\Livewire\AppointmentStatuses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AppointmentStatus;

class AllAppointmentStatusesListing extends Component
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
        $data = AppointmentStatus::query()
            ->select('appointment_statuses.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('appointment_statuses.name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('appointment_statuses.status', $this->status);
            })
            ->orderBy('appointment_statuses.created_at', 'desc')
            ->paginate(10);

        return view('livewire.appointment-statuses.all-appointment-statuses-listing', [
            'data' => $data,
            'page' => 'appointment_statuses',
        ]);
    }
}