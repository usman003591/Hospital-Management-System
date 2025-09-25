<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class AllPatientsListing extends Component
{
    use WithPagination;
    public $q = ''; // Search by name, MR number, or CNIC
    public $status = '';
    protected $paginationTheme = 'bootstrap'; // or tailwind

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
        $data = Patient::query()
            ->when($this->q !== '', fn ($query) =>
                $query->where(function ($q) {
                    $q->where('name_of_patient', 'ilike', "%{$this->q}%")
                      ->orWhere('patient_mr_number', 'ilike', "%{$this->q}%")
                      ->orWhere('cnic_number', 'ilike', "%{$this->q}%")
                                     ->orWhere('cell', 'ilike', "%{$this->q}%");
                }))
            ->when($this->status !== '', fn ($query) =>
                $query->where('status', (int) $this->status))
            ->orderBy('patients.created_at', 'desc')    
            ->paginate(10);

        return view('livewire.Patient.all-patients-listing', [
            'data' => $data,
            'page' => 'patients',
        ]);

    }
}
