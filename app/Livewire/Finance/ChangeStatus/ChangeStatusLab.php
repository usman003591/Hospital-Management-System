<?php

namespace App\Livewire\Finance\ChangeStatus;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\LabInvoice;
use Livewire\WithPagination;
use App\Models\FinanceVerificationAuditLog;
use App\Livewire\Finance\Verfication\Pathology;

class ChangeStatusLab extends Component
{
    public $invoiceId;
    public $changed_at;
    public $remarks;
    public $verification_status;
    public $old_value;
    public $selectedItems = [];
    protected $listeners = ['refreshLabFinanceStatus' => 'render'];

    protected $rules = [
        'changed_at' => 'required|date',
        'remarks' => 'required',
        'verification_status' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $item = LabInvoice::find($this->invoiceId);
        if ($item) {

            $old_value = $item->getOriginal('is_finance_verified');
            $item->is_finance_verified = $this->verification_status;
            $item->update();
            $ipAddress = request()->ip();

            $finance_log_data = [
                    'verifiable_type' => 'lab_invoices',
                    'verifiable_type_id' => $item->id,
                    'old_value' => $old_value,
                    'changed_at' => Carbon::now(),
                    'new_value' => $this->verification_status,
                    'changed_by' =>auth()->user()->id,
                    'remarks' => $this->remarks,
                    // 'created_at' => now(),
                    'ip_address' => $ipAddress,
                    'created_by' =>auth()->user()->id
                ];

                $verifiedObj = FinanceVerificationAuditLog::createAuditLog($finance_log_data);
            if($verifiedObj) {
                $this->dispatch('show-toast', type: 'success', message: 'Lab invoice status changed successfully!');
                $this->selectedItems = [];
            } else {
                $this->dispatch('show-toast', type: 'error', message: 'Failed to verify lab invoice!');
            }
        }

        $this->reset(['invoiceId','changed_at','remarks','verification_status','old_value']);
        $this->dispatch('hide-bootstrap-modal');
        $this->js('window.location.reload()');
    }

    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $log = FinanceVerificationAuditLog::where('verifiable_type_id', $invoiceId)
            ->where('verifiable_type', 'lab_invoices')
            ->latest()
            ->first();
        if ($log) {
            $this->verification_status = $log->new_value;
            $this->changed_at = Carbon::parse($log->getRawOriginal('changed_at'))->format('Y-m-d\TH:i');
            $this->remarks = $log->remarks;
        } else {
            $this->changed_at = now()->format('Y-m-d\TH:i');
            $this->verification_status = '';
            $this->remarks = '';
            $this->old_value = null;
        }
    }

    public function showModal()
    {
        $this->resetValidation();
        $this->dispatch('show-bootstrap-modal');
    }

    public function render()
    {
        return view('livewire.finance.change-status.change-status-lab');
    }
}
