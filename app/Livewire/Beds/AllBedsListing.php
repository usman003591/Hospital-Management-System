<?php

namespace App\Livewire\Beds;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bed;
use App\Models\Room;

class AllBedsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $room = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'room' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'room', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $search = [
            'q' => $this->q ?: false,
            'room' => $this->room ?: false,
            'status' => $this->status !== '' ? $this->status : false,
        ];

        $data = Bed::query()
            ->leftJoin('rooms as r', 'r.id', '=', 'beds.room_id')
            ->select([
                'beds.*',
                'r.room_number as room_name',
            ]);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('r.room_number', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('beds.bed_number', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['room']) {
            $data = $data->where('beds.room_id', $search['room']);
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('beds.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('beds.status', 0);
            }
        }

        $data = $data->orderBy('beds.created_at', 'desc')->paginate(10);

        $rooms = Room::pluck('room_number', 'id')->toArray();

        return view('livewire.beds.all-beds-listing', [
            'data' => $data,
            'page' => 'beds',
            'rooms' => $rooms,
        ]);
    }
}