<?php

namespace App\Livewire\Cashiers;

use App\Models\Cashier;
use Livewire\Component;
use Livewire\WithPagination;

class AllCashiersListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

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
        $data = Cashier::query()
            ->select('pos_cashiers.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('pos_cashiers.name', 'ILIKE', "%{$this->q}%"); 
                });
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('pos_cashiers.status', $this->status))
            ->orderBy('pos_cashiers.created_at', 'desc')
            ->paginate(10);

        return view('livewire.cashiers.all-cashiers-listing', [
            'data' => $data,
            'page' => 'cashiers'
        ]);
    }
}