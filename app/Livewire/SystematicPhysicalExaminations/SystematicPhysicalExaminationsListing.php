<?php

namespace App\Livewire\SystematicPhysicalExaminations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SystematicPhysicalExamination as SPE;

class SystematicPhysicalExaminationsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $parent_id = '';
    public $verification_status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'parent_id' => ['except' => ''],
        'verification_status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'parent_id', 'verification_status']);
        $this->resetPage();
    }

    public function changeStatus($id, $newStatus)
    {
        $examination = SPE::find($id);

        if ($examination) {
            $examination->verification_status = $newStatus;
            $examination->save();

            $this->dispatch('show-toast', 
                type: 'success', 
                message: 'Status updated successfully!'
            );
            // $this->render(); // Force re-render to update UI
        }
    }

    public function render()
    {
        $query = SPE::query()
            ->leftJoin('systematic_physical_examinations as parent', 'systematic_physical_examinations.parent_id', '=', 'parent.id')
            ->select([
                'systematic_physical_examinations.*',
                'parent.name as parent_name'
            ]);

        if ($this->q) {
            $query->where('systematic_physical_examinations.name', 'ILIKE', "%{$this->q}%");
        }

        if ($this->parent_id !== '') {
            if ($this->parent_id === '0') {
                $query->where('systematic_physical_examinations.parent_id', 0);
            } else {
                $query->where('systematic_physical_examinations.parent_id', $this->parent_id);
            }
        }

        if ($this->verification_status) {
            $query->where('systematic_physical_examinations.verification_status', $this->verification_status);
        }

        $data = $query->orderBy('systematic_physical_examinations.created_at', 'desc')
            ->paginate(10);

        $parentExaminations = SPE::where('parent_id', 0)
            ->get()
            ->pluck('name', 'id')
            ->prepend('Parent Examination', '0');

        return view('livewire.systematic-physical-examinations.systematic-physical-examinations-listing', [
            'data' => $data,
            'parentExaminations' => $parentExaminations,
            'page' => 'systematic_physical_examinations',
        ]);
    }
}