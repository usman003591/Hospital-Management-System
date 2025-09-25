<?php

namespace App\Livewire\MedicineRoutes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MedicineRoute; 
class AllMedicineRoutesListing extends Component
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
        $data = MedicineRoute::query()
            ->select('medicine_routes.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('medicine_routes.name', 'ILIKE', "%{$this->q}%"); 
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('medicine_routes.status', $this->status);
            })
            ->orderBy('medicine_routes.created_at', 'desc')
            ->paginate(10);

        return view('livewire.medicine_routes.all-medicine-routes-listing', [
            'data' => $data,
            'page' => 'medicine_routes',
        ]);
    }
}