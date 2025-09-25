<?php

namespace App\Livewire\TreatmentDosage;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TreatmentDosage;

class AllTreatmentDosageListing extends Component
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
        $data = TreatmentDosage::query()
            ->select('treatment_dosage.*')
            // ->withTrashed()
            ->when($this->q !== '', function ($query) {
                return $query->where('treatment_dosage.name', 'ILIKE', "%{$this->q}%"); 
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('treatment_dosage.status', $this->status);
            })
            ->orderBy('treatment_dosage.created_at', 'desc')
            ->paginate(10);

        return view('livewire.treatment_dosage.all-treatment-dosage-listing', [
            'data' => $data,
            'page' => 'treatment_dosage',
        ]);
    }
}