<?php

namespace App\Livewire\HospitalFloors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Floor;

class AllHospitalFloorsListing extends Component
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
        $data = Floor::query()
            ->select('floors.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('floors.floor_name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('floors.status', $this->status);
            })
            ->orderBy('floors.created_at', 'desc')
            ->paginate(10);

        return view('livewire.hospital-floors.all-hospital-floors-listing', [
            'data' => $data,
            'page' => 'floors',
        ]);
    }
}