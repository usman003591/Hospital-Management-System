<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class AllRolesListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

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
        $data = Role::query()
            ->select('roles.*')
            ->when($this->q !== '', function ($query) {
                $query->where('roles.name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->status !== '', fn ($query) =>
                $query->where('roles.status', $this->status))
            ->orderBy('roles.created_at', 'desc') 
            ->paginate(10);

        return view('livewire.roles.all-roles-listing', [
            'data' => $data,
            'page' => 'roles'
        ]);
    }
}