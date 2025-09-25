<?php

namespace App\Livewire\Vitals;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vital;

class AllVitalsListing extends Component
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
        $data = Vital::query()
            ->select('vitals.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('vitals.name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('vitals.status', $this->status);
            })
            ->orderBy('vitals.created_at', 'desc')
            ->paginate(10);

        return view('livewire.vitals.all-vitals-listing', [
            'data' => $data,
            'page' => 'vitals',
        ]);
    }
}