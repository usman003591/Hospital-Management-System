<?php

namespace App\Livewire\OpdCounters;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OPDCounter; 

class AllOpdCountersListing extends Component
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
        $data = OPDCounter::query()
            ->select('o_p_d_counters.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('o_p_d_counters.name', 'ILIKE', "%{$this->q}%"); 
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('o_p_d_counters.status', $this->status);
            })
            ->orderBy('o_p_d_counters.created_at', 'desc')
            ->paginate(10);

        return view('livewire.opd-counters.all-opd-counters-listing', [
            'data' => $data,
            'page' => 'opd_counter',
        ]);
    }
   
}