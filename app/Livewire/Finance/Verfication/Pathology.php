<?php

namespace App\Livewire\Finance\Verfication;

use Livewire\Component;
use App\Models\Hospital;
use App\Models\LabInvoice;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\FinanceVerificationAuditLog;

class Pathology extends Component
{
    use WithPagination;

    public $q = '';
    public $hospital_id = '';
    protected $paginationTheme = 'bootstrap';
    // Bulk-select state
    public $selectedItems = [];
    public $selectAll = false;

    #[On('refreshMe')]
    public function refreshMe(): void
    {
        // Optional: if you paginate/filter, reset as needed
        $this->resetPage();
    }
    // Reset pagination & selection when filters change
    public function updating($name, $value)
    {
        $this->resetPage();

        if (in_array($name, ['q', 'hospital_id'])) {
            $this->resetSelection();
        }
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id']);
        $this->resetPage();
        $this->resetSelection();
    }

    private function resetSelection(): void
    {
        $this->selectedItems = [];
    }

    public function verifySelected()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-toast', type: 'error', message: 'No items selected to verify!');
            return;
        }

        foreach ($this->selectedItems as $id) {
            $item = LabInvoice::find($id);
            if ($item) {
                $item->is_finance_verified = true;
                $item->update();
                $ipAddress = request()->ip();
                $finance_log_data = [
                    'verifiable_type' => 'lab_invoices',
                    'verifiable_type_id' => $item->id,
                    'old_value' => false,
                    'new_value' => true,
                    'changed_at' => now(),
                    'changed_by' =>auth()->user()->id,
                    'created_at' => now(),
                    'ip_address' => $ipAddress,
                    'created_by' =>auth()->user()->id
                ];

                $verifiedObj = FinanceVerificationAuditLog::createAuditLog($finance_log_data);
                if($verifiedObj) {
                    $this->dispatch('show-toast', type: 'success', message: 'Lab invoices verified successfully!');
                    $this->selectedItems = [];
                } else {
                    $this->dispatch('show-toast', type: 'error', message: 'Failed to verify Lab invoice!');
                }
            }
        }
    }
    /**
     * Base query reused by table + bulk actions
     */
    protected function baseQuery()
    {
        return LabInvoice::query()
            ->leftJoin('hospitals', 'lab_invoices.hospital_id', '=', 'hospitals.id')
            ->with(['hospital', 'patient'])
            ->when($this->q !== '', function ($query) {
                $query->where(function ($q) {
                    $term = "%{$this->q}%";
                    $q->where('invoice_sequence', 'ilike', $term)
                      ->orWhereHas('patient', fn ($q) => $q->where('name_of_patient', 'ilike', $term))
                      ->orWhereHas('patient', fn ($q) => $q->where('cell', 'ilike', $term))
                      ->orWhereHas('patient', fn ($q) => $q->where('patient_mr_number', 'ilike', $term));
                });
            })
            ->when($this->hospital_id !== '', fn ($q) =>
                $q->where('lab_invoices.hospital_id', $this->hospital_id)
            );
    }

    public function render()
    {
        $hospitals = Hospital::select('id', 'name')->get();

        $data = $this->baseQuery()
            ->select([
                'lab_invoices.*',
                'hospitals.name as hospital_name',
            ])
            ->orderBy('lab_invoices.created_at', 'desc')
            ->paginate(10);

        return view('livewire.finance.verfication.pathology', [
            'data' => $data,
            'hospitals' => $hospitals,
            'page' => 'lab_invoices',
        ]);
    }
    /**
     * When header checkbox toggles: select/deselect current page IDs
     */


}
