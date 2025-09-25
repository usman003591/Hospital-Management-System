<?php

namespace App\Livewire\Invoices;

use App\Models\Hospital;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class AllInvoicesListing extends Component
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

        $data = Invoice::query()
            ->with(['hospital', 'patient', 'paymentStatus'])
            ->when($this->q !== '', fn ($query) =>
                $query->where(function ($q) {
                    $q->where('receipt_number', 'ilike', "%{$this->q}%")
                      ->orWhereHas('patient', fn ($q) => $q->where('name_of_patient', 'ilike', "%{$this->q}%"))
                      ->orWhereHas('patient', fn ($q) => $q->where('cell', 'ilike', "%{$this->q}%"));
                }))
            ->when($this->hospital_id !== '', fn ($query) =>
                $query->where('hospital_id', $this->hospital_id))
            ->orderBy('invoices.created_at', 'desc')    
            ->paginate(10);

        return view('livewire.invoices.all-invoices-listing', [
            'data' => $data,
            'hospitals' => $hospitals,
            'page' => 'invoices',
        ]);

    }
}
