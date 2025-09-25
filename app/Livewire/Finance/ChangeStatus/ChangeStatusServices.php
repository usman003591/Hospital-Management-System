<?php

namespace App\Livewire\Finance\ChangeStatus;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\LabInvoice;
use Livewire\WithPagination;
use App\Models\FinanceVerificationAuditLog;

class ChangeStatusServices extends Component
{
    public $invoiceId;
    public $changed_at;
    public $remarks;
    public $verification_status;
    public $old_value;
    public $log;
    protected $listeners = ['refreshServicesFinanceStatus' => 'render'];

    protected $rules = [
        'changed_at' => 'required|date',
        'remarks' => 'required',
        'verification_status' => 'required',
    ];

    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $log = FinanceVerificationAuditLog::where('verifiable_type_id', $invoiceId)
            ->where('verifiable_type', 'services_invoices')
            ->latest()
            ->first();
        if ($log) {
            $this->log = $log;
            $this->verification_status = $log->new_value;
            $this->changed_at = \Carbon\Carbon::parse($log->getRawOriginal('changed_at'))->format('Y-m-d\TH:i');
            $this->remarks = $log->remarks;
            $this->old_value = $log->new_value;
        } else {
            $this->changed_at = now()->format('Y-m-d\TH:i');
            $this->verification_status = '';
            $this->remarks = '';
            $this->old_value = null;
        }
    }

    public function submit()
    {
        $this->validate();

        $item = Invoice::find($this->invoiceId);
        if ($item) {

            $item->is_finance_verified = $this->verification_status;
            $item->update();
            $ipAddress = request()->ip();

            $finance_log_data = [
                    'verifiable_type' => 'services_invoices',
                    'verifiable_type_id' => $item->id,
                    'old_value' => $this->old_value,
                    'changed_at' => \Carbon\Carbon::now(),
                    'new_value' => $this->verification_status,
                    'changed_by' =>auth()->user()->id,
                    'created_at' => now(),
                    'ip_address' => $ipAddress,
                    'remarks' => $this->remarks,
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
        $this->reset(['invoiceId','changed_at','remarks','verification_status','old_value']);
        $this->dispatch('hide-bootstrap-modal');
        $this->js('window.location.reload()');
    }

    public function showModal()
    {
        $this->resetValidation();
        $this->dispatch('show-bootstrap-modal');
    }
    public function render()
    {
        return view('livewire.finance.change-status.change-status-services');
    }
}
