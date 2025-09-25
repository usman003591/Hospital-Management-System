<?php

namespace App\Livewire\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;

class AllPaymentMethodsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'status' => ['except' => '']
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
        $data = PaymentMethod::query()
            ->select('pos_payment_methods.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('pos_payment_methods.name', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('pos_payment_methods.status', $this->status))
            ->orderBy('pos_payment_methods.created_at', 'desc') // Latest records at top
            ->paginate(10);

        return view('livewire.payment_methods.all-payment-methods-listing', [
            'data' => $data,
            'page' => 'payment_methods'
        ]);
    }
}