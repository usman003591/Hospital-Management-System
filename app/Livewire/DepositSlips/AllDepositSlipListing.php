<?php

namespace App\Livewire\DepositSlips;

use App\Models\DepositSlip;
use App\Models\Hospital;
use Livewire\Component;
use Livewire\WithPagination;

class AllDepositSlipListing extends Component
{
    use WithPagination;

    public $q = '';
    public $hospital = '';
    protected $paginationTheme = 'bootstrap';

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital']);
        $this->resetPage();
    }

    public function render()
    {
        $hospitals = Hospital::getActiveHospitals();

        $data = DepositSlip::query()
            ->join('hospitals as h', 'h.id', '=', 'deposit_slips.hospital_id')
            ->join('users as u', 'u.id', '=', 'deposit_slips.user_id')
            // ->leftJoin('o_p_d_counters as c', 'c.id', '=', 'deposit_slips.counter_id')
            ->select(
                'deposit_slips.*',
                'h.name as hospital_name',
                'u.name as user_name',
                // 'c.name as counter_name'
            )
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('deposit_slips.deposit_slip_number', 'ILIKE', "%{$this->q}%")
                            ->orWhere('u.name', 'ILIKE', "%{$this->q}%");
                });
            })
            ->when($this->hospital !== '', fn ($query) =>
                $query->where('deposit_slips.hospital_id', $this->hospital))
            ->orderBy('deposit_slips.created_at', 'desc')   
            ->paginate(10);

        return view('livewire.deposit-slips.all-deposit-slip-listing', [
            'data' => $data,
            'page' => 'deposit_slips',
            'hospitals' => $hospitals
        ]);
    }
}