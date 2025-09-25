<?php

namespace App\Livewire\Wards;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ward;
use App\Models\Floor;

class AllWardsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $floor = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'floor' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'floor', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $data = Ward::query()
            ->leftJoin('floors as f', 'f.id', '=', 'wards.floor_id')
            ->select([
                'wards.*',
                'f.floor_name as floor_name',
            ]);

        if (!empty($this->q)) {
            $data->where(function ($query) {
                $query->where('wards.ward_name', 'ILIKE', "%{$this->q}%")
                      ->orWhere('wards.ward_description', 'ILIKE', "%{$this->q}%")
                      ->orWhere('f.floor_name', 'ILIKE', "%{$this->q}%");
            });
        }

        if ($this->status !== '') {
            $data->where('wards.status', $this->status);
        }

        if (!empty($this->floor)) {
            $data->where('wards.floor_id', $this->floor);
        }

        $data = $data->orderBy('wards.created_at', 'desc')->paginate(10);

        $floors = Floor::pluck('floor_name', 'id')->toArray();

        return view('livewire.wards.all-wards-listing', [
            'data' => $data,
            'page' => 'wards',
            'floors' => $floors,
        ]);
    }
}
