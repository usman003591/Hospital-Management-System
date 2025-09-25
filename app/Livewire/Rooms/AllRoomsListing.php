<?php

namespace App\Livewire\Rooms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Room;
use App\Models\Ward;

class AllRoomsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $ward = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'ward' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'ward', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $search = [
            'q' => $this->q ?: false,
            'ward' => $this->ward ?: false,
            'status' => $this->status !== '' ? $this->status : false,
        ];

        $data = Room::query()
            ->leftJoin('wards as w', 'w.id', '=', 'rooms.ward_id')
            ->select([
                'rooms.*',
                'w.ward_name as ward_name',
            ]);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('rooms.room_number', 'ILIKE', "%{$search['q']}%")
                    ->orWhere('rooms.room_description', 'ILIKE', "%{$search['q']}%")
                    ->orWhere('w.ward_name', 'ILIKE', "%{$search['q']}%");
            });
        }

        if ($search['status'] !== false) {
            if ($search['status'] == 1) {
                $data = $data->where('rooms.status', 1);
            } elseif ($search['status'] == 0) {
                $data = $data->where('rooms.status', 0);
            }
        }

        if ($search['ward']) {
            $data = $data->where('rooms.ward_id', $search['ward']);
        }

        $data = $data->orderBy('rooms.created_at', 'desc')->paginate(10);

        $wards = Ward::pluck('ward_name', 'id')->toArray();

        return view('livewire.rooms.all-rooms-listing', [
            'data' => $data,
            'page' => 'rooms',
            'wards' => $wards,
        ]);
    }
}