<?php

namespace App\Livewire\MedicineDurations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MedicineDuration; 

class AllMedicineDurationListing extends Component
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
        $data = MedicineDuration::query()
            ->select('medicine_durations.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('medicine_durations.name', 'ILIKE', "%{$this->q}%"); 
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('medicine_durations.status', $this->status);
            })
            ->orderBy('medicine_durations.created_at', 'desc')
            ->paginate(10);

        return view('livewire.medicine_durations.all-medicine-durations-listing', [
            'data' => $data,
            'page' => 'medicine_durations',
        ]);
    }
}