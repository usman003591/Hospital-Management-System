<?php

namespace App\Livewire\Hospitals;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Hospital;

class AllHospitalsListing extends Component
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
        $data = Hospital::query()
            // ->select('hospitals.*')
            // ->when($this->q !== '', function ($query) {
            //     return $query->where('hospitals.name', 'ILIKE', "%{$this->q}%")
            //      ->orWhere('hospitals.hospital_abbreviation', 'iLIKE', "%{$this->q}%");
            // })
            ->select('hospitals.*')
            ->when($this->q !== '', function ($query) {
                return $query->where(function ($q) {
                    $q->where('hospitals.name', 'ILIKE', "%{$this->q}%")
                    ->orWhere('hospitals.hospital_abbreviation', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('hospitals.status', $this->status);
            })
            ->orderBy('hospitals.created_at', 'desc')
            ->paginate(10);

        return view('livewire.hospitals.all-hospitals-listing', [
            'data' => $data,
            'page' => 'hospitals',
        ]);
    }
}