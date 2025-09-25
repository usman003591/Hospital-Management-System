<?php

namespace App\Livewire\Finance\Verfication;

use Livewire\Component;
use App\Models\Hospital;
use App\Models\PosInvocie;
use Livewire\WithPagination;
use App\Models\FinanceVerificationAuditLog;

class Pharmacy extends Component
{
    use WithPagination;
    public $q = '';
    public $hospital_id = '';

    public $selectedItems = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function verifySelected()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-toast', type: 'error', message: 'No items selected to verify!');
            return;
        }

        foreach ($this->selectedItems as $id) {
            $item = PosInvocie::find($id);
            if ($item) {
                $item->is_finance_verified = true;
                $item->update();
                $ipAddress = request()->ip();
                $finance_log_data = [
                    'verifiable_type' => 'pos_invoices',
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
                    $this->dispatch('show-toast', type: 'success', message: 'POS invoices verified successfully!');
                    $this->selectedItems = [];
                } else {
                    $this->dispatch('show-toast', type: 'error', message: 'Failed to verify POS invoice!');
                }
            }
        }
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id']);
        $this->resetPage();
    }

    public function render()
    {
        $hospitals = Hospital::getActiveHospitals();

        $data = \DB::table('pos_orders as order')
        ->leftJoin('hospitals', 'order.hospital_id', '=', 'hospitals.id')
        ->join('pos_invoices as invoice', function ($join) {
                $join->on('invoice.order_id', '=', 'order.id')
                    ->whereNull('invoice.deleted_at');
            })
            ->leftJoin('patients as p', 'p.id', '=', 'order.patient_id')
            ->whereNull('order.deleted_at')
            ->select([
                'order.id as order_id',
                'order.order_number as invoice_sequence',
                'order.order_date as date_issued',
                'order.total_amount',
                'order.total_items',
                'order.cashier_id',
                'order.patient_id',
                'order.payment_method_id',
                'order.order_status_id',
                'order.hospital_id',
                'invoice.invoice_number',
                'invoice.dateIssued',
                'invoice.final_amount',
                'invoice.invoice_file_name',
                'invoice.invoice_file_path',
                'p.name_of_patient',
                'p.cell',
                'hospitals.name as hospital_name',
                'invoice.*'
            ])
            ->when($this->q !== '', function ($query) {
                $term = "%{$this->q}%";
                $query->where(function ($q) use ($term) {
                    $q->where('order.order_number', 'ILIKE', $term)
                    ->orWhere('invoice.invoice_number', 'ILIKE', $term)
                    ->orWhere('p.name_of_patient', 'ILIKE', $term)
                    ->orWhere('p.cell', 'ILIKE', $term)
                    ->orWhere('p.patient_mr_number', 'ILIKE', $term);
                });
            })
            ->when($this->hospital_id !== '', function ($query) {
                $query->where('order.hospital_id', $this->hospital_id);
            })
            ->orderBy('invoice.created_at', 'desc')
            ->paginate(10);


        return view('livewire.finance.verfication.pharmacy', compact('hospitals', 'data'));
    }
}
