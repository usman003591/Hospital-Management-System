<?php

namespace App\Livewire\MedicineInventoryStatuses;

use App\Models\MedicineInventoryStatus;
use Livewire\Component;
use Livewire\WithPagination;

class AllMedicineInventoryStatusesListing extends Component
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
        $data = MedicineInventoryStatus::query()
            ->select('pos_medicine_inventory_statuses.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('pos_medicine_inventory_statuses.name', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('pos_medicine_inventory_statuses.status', $this->status))
            ->orderBy('pos_medicine_inventory_statuses.created_at', 'desc') // Latest records at top
            ->paginate(10);

        return view('livewire.medicine_inventory_statuses.all-medicine-inventory-statuses-listing', [
            'data' => $data,
            'page' => 'medicine_inventory_statuses'
        ]);
    }
}