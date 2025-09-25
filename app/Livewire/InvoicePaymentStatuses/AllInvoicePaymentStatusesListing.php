<?php

namespace App\Livewire\InvoicePaymentStatuses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InvoicePaymentStatus; 

class AllInvoicePaymentStatusesListing extends Component
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
        $data = InvoicePaymentStatus::query()
            ->select('invoice_payment_statuses.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('invoice_payment_statuses.name', 'ILIKE', "%{$this->q}%"); 
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('invoice_payment_statuses.status', $this->status);
            })
            ->orderBy('invoice_payment_statuses.created_at', 'desc')
            ->paginate(10);

        return view('livewire.invoice_payment_statuses.all-invoice-payment-statuses-listing', [
            'data' => $data,
            'page' => 'invoice_payment_statuses',
        ]);
    }
}