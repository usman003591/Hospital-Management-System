<?php

namespace App\Livewire\Invoices\Labs;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\LabInvoice;
use Livewire\WithPagination;

class AllLabInvoicesListing extends Component
{
    use WithPagination;
    public $q = '';
    public $hospital_id = '';
    protected $paginationTheme = 'bootstrap';

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id']);
        $this->resetPage();
    }
    public function render()
    {
        $hospitals = Hospital::all();
        $data = LabInvoice::query()
            ->with(['hospital', 'patient'])
            ->when($this->q !== '', fn ($query) =>
                $query->where(function ($q) {
                    $q->where('receipt_number', 'ilike', "%{$this->q}%")
                      ->orWhereHas('patient', fn ($q) => $q->where('name_of_patient', 'ilike', "%{$this->q}%"))
                      ->orWhereHas('patient', fn ($q) => $q->where('cell', 'ilike', "%{$this->q}%"));
                }))
            ->when($this->hospital_id !== '', fn ($query) =>
                $query->where('hospital_id', $this->hospital_id))
            ->orderBy('lab_invoices.created_at', 'desc')
            ->paginate(10);

        return view('livewire.invoices.labs.all-lab-invoices-listing', [
            'data' => $data,
            'hospitals' => $hospitals,
            'page' => 'lab_invoices',
        ]);

    }
}
