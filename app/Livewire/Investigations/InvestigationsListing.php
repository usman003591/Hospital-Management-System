<?php

namespace App\Livewire\Investigations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Investigations;

class InvestigationsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $type_id = '';
    
    public $verification_status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'type_id' => ['except' => ''],
        'verification_status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'type_id', 'verification_status']);
        $this->resetPage();
    }

    public function changeStatus($id, $newStatus)
    {
        $investigation = Investigations::find($id);

        if ($investigation) {
            $investigation->verification_status = $newStatus;
            $investigation->save();

            $this->dispatch('show-toast',
                type: 'success',
                message: 'Status updated successfully!'
            );
            $this->render();
        }
    }

    public function render()
    {
        $query = Investigations::query()
            ->select('investigations.*')
            ->leftJoin('investigation_types', 'investigations.type_id', '=', 'investigation_types.id')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('investigations.name', 'ILIKE', "%{$this->q}%")
                             ->orWhere('investigation_types.name', 'ILIKE', "%{$this->q}%")
                             ->orWhere('investigations.is_in_house', 'ILIKE', "%{$this->q}%")
                             ->orWhere('investigations.is_manual', 'ILIKE', "%{$this->q}%");
                });
            });

        if ($this->type_id) {
            $query->where('investigations.type_id', $this->type_id);
        }

        if ($this->verification_status) {
            $query->where('investigations.verification_status', $this->verification_status);
        }

        $data = $query->orderBy('investigations.created_at', 'desc')
            ->paginate(10);

        $investigationTypes = \App\Models\InvestigationType::pluck('name', 'id')->prepend('Select Investigation Type', '');

        return view('livewire.investigations.investigations-listing', [
            'data' => $data,
            'page' => 'investigations',
            'investigationTypes' => $investigationTypes,
        ]);
    }
}
