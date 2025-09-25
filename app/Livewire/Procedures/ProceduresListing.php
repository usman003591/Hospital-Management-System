<?php

namespace App\Livewire\Procedures;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Procedure;

class ProceduresListing extends Component
{
    use WithPagination;

    public $q = '';
     public $status = '';
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
        $procedure = Procedure::find($id);

        if ($procedure) {
            $procedure->verification_status = $newStatus;
            $procedure->save();

            $this->dispatch('show-toast', 
                type: 'success', 
                message: 'Status updated successfully!'
            );
        }
    }

    public function render()
    {
        $query = Procedure::query()
            ->select('procedures.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('procedures.name', 'ILIKE', "%{$this->q}%")
                             ->orWhere('procedures.is_manual', 'ILIKE', "%{$this->q}%");
                });
            });

        if ($this->status) {
            $query->where('procedures.status', $this->status === 'active' ? 1 : 0);
        }
        if ($this->verification_status) {
            $query->where('procedures.verification_status', $this->verification_status);
        }

        $data = $query->orderBy('procedures.created_at', 'desc')
            ->paginate(10);

        return view('livewire.procedures.procedures-listing', [
            'data' => $data,
            'page' => 'procedures',
        ]);
    }
}