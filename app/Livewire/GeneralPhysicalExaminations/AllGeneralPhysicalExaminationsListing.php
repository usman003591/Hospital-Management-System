<?php

namespace App\Livewire\GeneralPhysicalExaminations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GeneralPhysicalExamination;

class AllGeneralPhysicalExaminationsListing extends Component
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
        $examination = GeneralPhysicalExamination::find($id);

        if ($examination) {
            $examination->verification_status = $newStatus;
            $examination->save();

            $this->dispatch('show-toast', 
                type: 'success', 
                message: 'Status updated successfully!'
            );
        }
    }

    public function render()
    {
        $query = GeneralPhysicalExamination::query()
            ->leftJoin('general_physical_examinations as parent', 'general_physical_examinations.parent_id', '=', 'parent.id')
            ->select([
                'general_physical_examinations.*',
                'parent.name as parent_name'
            ]);

        if ($this->q) {
            $query->where('general_physical_examinations.name', 'ILIKE', "%{$this->q}%");
        }

        if ($this->parent_id !== '') {
            if ($this->parent_id === '0') {
                $query->where('general_physical_examinations.parent_id', 0);
            } else {
                $query->where('general_physical_examinations.parent_id', $this->parent_id);
            }
        }

        if ($this->verification_status) {
            $query->where('general_physical_examinations.verification_status', $this->verification_status);
        }

        $data = $query->orderBy('general_physical_examinations.created_at', 'desc')
            ->paginate(10);

        $parentExaminations = GeneralPhysicalExamination::where('parent_id', 0)
            ->get()
            ->pluck('name', 'id')
            ->prepend('Parent Examination', '0');

        return view('livewire.general-physical-examinations.all-general-physical-examinations-listing', [
            'data' => $data,
            'parentExaminations' => $parentExaminations,
            'page' => 'general_physical_examinations',
        ]);
    }
}