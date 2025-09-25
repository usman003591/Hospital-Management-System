<?php

namespace App\Livewire\DepositSlips;

use Livewire\Component;
use App\Models\Hospital;
use App\Models\DepositSlip;
use Livewire\WithPagination;
use App\Models\UserPreferences;

class DepositSlipListing extends Component
{
    use WithPagination;

    public $q = '';
    protected $paginationTheme = 'bootstrap';

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q']);
        $this->resetPage();
    }

    public function render()
    {
        $hospitals = Hospital::getActiveHospitals();
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];

        $data = DepositSlip::query()
            ->join('hospitals as h', 'h.id', '=', 'deposit_slips.hospital_id')
            ->join('users as u', 'u.id', '=', 'deposit_slips.user_id')
          
            ->select(
                'deposit_slips.*',
                'h.name as hospital_name',
                'u.name as user_name',
             
            )
            ->where('h.id', $hospital_id)
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('deposit_slips.deposit_slip_number', 'ILIKE', "%{$this->q}%")
                            ->orWhere('u.name', 'ILIKE', "%{$this->q}%");
                });
            })
            ->orderBy('deposit_slips.created_at', 'desc')
            ->paginate(10);

        return view('livewire.deposit-slips.deposit-slip-listing', [
            'data' => $data,
            'page' => 'deposit_slips',
            'hospitals' => $hospitals
        ]);
    }
}