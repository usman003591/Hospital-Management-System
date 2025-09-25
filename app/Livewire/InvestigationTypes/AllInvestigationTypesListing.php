<?php

namespace App\Livewire\InvestigationTypes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InvestigationType;

class AllInvestigationTypesListing extends Component
{
    use WithPagination;

    public $q = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
    ];

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
        $data = InvestigationType::query()
            ->select('investigation_types.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('investigation_types.name', 'ILIKE', "%{$this->q}%");
            })
            ->orderBy('investigation_types.created_at', 'desc')
            ->paginate(10);

        return view('livewire.investigation-types.all-investigation-types-listing', [
            'data' => $data,
            'page' => 'investigation_types',
        ]);
    }
}