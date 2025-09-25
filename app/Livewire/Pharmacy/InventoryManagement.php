<?php

namespace App\Livewire\Pharmacy;

use Livewire\Component;
use App\Models\Hospital;
use Livewire\WithPagination;
use App\Models\UserPreferences;
use App\Models\PosMedicineInventory;
use App\Models\PosMedicineInventoryStatus;

class InventoryManagement extends Component
{
    use WithPagination;
    public $q = '';
    public $status = '';

    protected $paginationTheme = 'bootstrap';

    public function updating()
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
        $hospitals = Hospital::getActiveHospitals();
        $inventory_statuses = PosMedicineInventoryStatus::getActiveMedicineInventoryStatuses();

        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $inventories = PosMedicineInventory::join('medicines as medicine', 'medicine.id', 'pos_medicine_inventory.medicine_id')
        ->join('hospitals as hospital', 'hospital.id', 'pos_medicine_inventory.hospital_id')
        ->join('pos_medicine_inventory_statuses as pmi', 'pmi.id', 'pos_medicine_inventory.medicine_inventory_status_id')
        ->select([
            'medicine.name as medicine_name',
            'hospital.name as hospital_name',
            'pmi.name as medicine_inventory_status',
            'pos_medicine_inventory.*'
        ])
        ->where('pos_medicine_inventory.hospital_id', $hospital_id)
        ->when($this->q !== '', function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->where('medicine.name', 'ILIKE', "%{$this->q}%");
            });
        })
        ->when($this->status !== '', fn ($query) =>
            $query->where('pmi.id', $this->status))
        ->orderBy('pos_medicine_inventory.created_at', 'desc')
        ->paginate(10);


        return view('livewire.pharmacy.inventory-management', [
            'data' => $inventories,
            'page' => 'inventory_management',
            'inventory_statuses' => $inventory_statuses
        ]);
    }

}
