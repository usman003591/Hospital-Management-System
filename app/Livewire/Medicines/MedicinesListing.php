<?php

namespace App\Livewire\Medicines;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Medicines;

class MedicinesListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = ''; // New status filter
    public $verification_status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'status' => ['except' => ''],
        'verification_status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'status', 'verification_status']);
        $this->resetPage();
    }

    public function changeStatus($id, $newStatus)
    {
        $medicine = Medicines::find($id);

        if ($medicine) {
            $medicine->verification_status = $newStatus;
            $medicine->save();

            $this->dispatch('show-toast', 
                type: 'success', 
                message: 'Status updated successfully!'
            );
            
        }
    }

    public function render()
{
    $query = Medicines::query()
        ->select('medicines.*')
        ->when($this->q !== '', function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->where('medicines.is_in_house', 'ILIKE', "%{$this->q}%")
                    ->orWhere('medicines.is_manual', 'ILIKE', "%{$this->q}%")
                    ->orWhere('medicines.name', 'ILIKE', "%{$this->q}%");
            });
        });
    
    if ($this->status) {
                $query->where('medicines.status', $this->status === 'active' ? 1 : 0);
            }

    if ($this->verification_status) {
        $query->where('medicines.verification_status', $this->verification_status);
    }

    $data = $query->orderBy('medicines.created_at', 'desc')
        ->paginate(10);

    return view('livewire.medicines.medicines-listing', [
        'data' => $data,
        'page' => 'medicines',
    ]);
}


}