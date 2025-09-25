<?php

namespace App\Livewire\Complaints;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Complaint;

class AllComplaintsListing extends Component
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

    // public function changeStatus($id, $status)
    // {
    //     $complaint = Complaint::find($id);
    //     $complaint->verification_status = $status;
    //     $complaint->save();
        
    //     $this->dispatch('show-message', ['type' => 'success', 'message' => 'Status updated successfully','position' => 'bottom-right']);
    // }



   public function changeStatus($id, $newStatus)
{
    $complaint = Complaint::find($id);

    if ($complaint) {
        $complaint->verification_status = $newStatus;
        $complaint->save();

        $this->dispatch('show-toast', 
            type: 'success', 
            message: 'Status updated successfully!'
        );
    }
}




    public function render()
    {
        $query = Complaint::query()
            ->leftJoin('complaints as parent', 'complaints.parent_id', '=', 'parent.id')
            ->select([
                'complaints.*',
                'parent.name as parent_name'
            ]);
            
        if ($this->q) {
            $query->where('complaints.name', 'ILIKE', "%{$this->q}%");
        }
        
        if ($this->parent_id !== '') {
            if ($this->parent_id === '0') {
                $query->where('complaints.parent_id', 0);
            } else {
                $query->where('complaints.parent_id', $this->parent_id);
            }
        }
        
        if ($this->verification_status) {
            $query->where('complaints.verification_status', $this->verification_status);
        }
        
        $data = $query->orderBy('complaints.created_at', 'desc')
            ->paginate(10);
            
        $parentComplaints = Complaint::where('parent_id', 0)
            ->get()
            ->pluck('name', 'id')
            ->prepend('Parent Complaint', '0');

        return view('livewire.complaints.all-complaints-listing', [
            'data' => $data,
            'parentComplaints' => $parentComplaints,
            'page' => 'complaints',
        ]);
    }
}