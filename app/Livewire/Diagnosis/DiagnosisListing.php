<?php

namespace App\Livewire\Diagnosis;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Diagnosis;

class DiagnosisListing extends Component
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
        $diagnosis = Diagnosis::find($id);

        if ($diagnosis) {
            $diagnosis->verification_status = $newStatus;
            $diagnosis->save();

            $this->dispatch('show-toast', 
                type: 'success', 
                message: 'Status updated successfully!'
            );
        }
    }

    public function render()
    {
        $query = Diagnosis::query()
            ->select('diagnosis.*')
            ->when($this->q !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('diagnosis.name', 'ILIKE', "%{$this->q}%")
                             ->orWhere('diagnosis.is_manual', 'ILIKE', "%{$this->q}%")
                             ->orWhere('diagnosis.code', 'ILIKE', "%{$this->q}%");
                });
            });

        if ($this->status) {
            $query->where('diagnosis.status', $this->status === 'active' ? 1 : 0);
        }

        if ($this->verification_status) {
            $query->where('diagnosis.verification_status', $this->verification_status);
        }

        $data = $query->orderBy('diagnosis.created_at', 'desc')
            ->paginate(10);

        return view('livewire.diagnosis.diagnosis-listing', [
            'data' => $data,
            'page' => 'diagnosis',
        ]);
    }
}