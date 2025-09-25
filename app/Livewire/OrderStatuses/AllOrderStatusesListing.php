<?php

namespace App\Livewire\OrderStatuses;

use App\Models\OrderStatus;
use Livewire\Component;
use Livewire\WithPagination;

class AllOrderStatusesListing extends Component
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
        $data = OrderStatus::query()
            ->select('pos_order_statuses.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('pos_order_statuses.name', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('pos_order_statuses.status', $this->status))
            ->orderBy('pos_order_statuses.created_at', 'desc') 
            ->paginate(10);

        return view('livewire.order_statuses.all-order-statuses-listing', [
            'data' => $data,
            'page' => 'order_statuses'
        ]);
    }
}