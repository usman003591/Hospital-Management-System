<?php

namespace App\Livewire\Finance\Verfication;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\FinanceVerificationAuditLog;
use Livewire\WithPagination;

class ServiceCategories extends Component
{
    use WithPagination;

    public $q = '';
    public $hospital_id = '';
    protected $paginationTheme = 'bootstrap';

    public $selectedItems = [];
    public $selectAll = false;

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id']);
        $this->resetPage();
    }

    public function verifySelected()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-toast', type: 'error', message: 'No items selected to verify!');
            return;
        }

        foreach ($this->selectedItems as $id) {
            $item = Invoice::find($id);
            if ($item) {
                $item->is_finance_verified = true;
                $item->update();
                $ipAddress = request()->ip();
                $finance_log_data = [
                    'verifiable_type' => 'services_invoices',
                    'verifiable_type_id' => $item->id,
                    'old_value' => false,
                    'changed_at' => now(),
                    'new_value' => true,
                    'changed_by' =>auth()->user()->id,
                    'created_at' => now(),
                    'ip_address' => $ipAddress,
                    'created_by' =>auth()->user()->id
                ];

                $verifiedObj = FinanceVerificationAuditLog::createAuditLog($finance_log_data);
                if($verifiedObj) {
                    $this->dispatch('show-toast', type: 'success', message: 'Service invoices verified successfully!');
                    $this->selectedItems = [];
                } else {
                    $this->dispatch('show-toast', type: 'error', message: 'Failed to verify service invoice!');
                }
            }
        }
    }

    public function render()
    {
        $hospitals = Hospital::all();
        $data = Invoice::query()
            ->leftJoin('hospitals', 'invoices.hospital_id', '=', 'hospitals.id')
            ->with(['hospital', 'patient', 'paymentStatus'])
            ->when($this->q !== '', fn ($query) =>
                $query->where(function ($q) {
                    $q->where('invoice_sequence', 'ilike', "%{$this->q}%")
                      ->orWhereHas('patient', fn ($q) => $q->where('name_of_patient', 'ilike', "%{$this->q}%"))
                      ->orWhereHas('patient', fn ($q) => $q->where('cell', 'ilike', "%{$this->q}%"))
                      ->orWhereHas('patient', fn ($q) => $q->where('patient_mr_number', 'ilike', "%{$this->q}%"));

                }))
            ->when($this->hospital_id !== '', fn ($query) =>
                $query->where('hospital_id', $this->hospital_id))
            ->select(['invoices.*', 'hospitals.name as hospital_name'])
            ->orderBy('invoices.created_at', 'desc')
            ->paginate(10);

        return view('livewire.finance.verfication.service-categories', [
            'data' => $data,
            'hospitals' => $hospitals,
            'page' => 'invoices',
        ]);
    }
}
