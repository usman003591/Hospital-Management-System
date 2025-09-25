<?php

namespace App\Livewire\TreatmentDoseInterval;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TreatmentDoseInterval;

class AllTreatmentDoseIntervalListing extends Component
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
        $data = TreatmentDoseInterval::query()
            ->select('treatment_dose_interval.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('treatment_dose_interval.name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('treatment_dose_interval.status', $this->status);
            })
            ->orderBy('treatment_dose_interval.created_at', 'desc')
            ->paginate(10);

        return view('livewire.treatment_dose_interval.all-treatment-dose-interval-listing', [
            'data' => $data,
            'page' => 'treatment_dose_interval',
        ]);
    }
}
