<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AllUsersListing extends Component
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
        $data = User::query()
            ->join('roles as r', 'r.id', '=', 'users.role_id')
            ->select(
                'users.*',
                'r.name as role_name'
            )
           ->when($this->q !== '', function ($query) {
                $query->where('users.name', 'ILIKE', "%{$this->q}%");
            })

            ->when($this->status !== '', fn ($query) =>
                $query->where('users.status', $this->status))
            ->orderBy('users.created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.all-users-listing', [
            'data' => $data,
            'page' => 'users'
        ]);
    }
}