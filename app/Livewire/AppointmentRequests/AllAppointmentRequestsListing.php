<?php

namespace App\Livewire\AppointmentRequests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AppointmentRequest;
use Dompdf\FrameDecorator\Page;

class AllAppointmentRequestsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $hospital_id = '';
    public $doctor_id = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'hospital_id' => ['except' => ''],
        'doctor_id' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id', 'doctor_id', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $query = AppointmentRequest::query()
            ->select('appointment_requests.*')
            ->with(['hospital', 'doctor'])
            ->when($this->q !== '', function ($query) {
                $query->where('appointment_requests.patient_name', 'ILIKE', "%{$this->q}%");
            })
            ->when($this->hospital_id, function ($query) {
                $query->where('appointment_requests.hospital_id', $this->hospital_id);
            })
            ->when($this->doctor_id, function ($query) {
                $query->where('appointment_requests.doctor_id', $this->doctor_id);
            })
            ->when($this->status, function ($query) {
                $query->where('appointment_requests.appointment_request_status', $this->status);
            });

        $data = $query->orderBy('appointment_requests.created_at', 'desc')
            ->paginate(10);

        $hospitals = \App\Models\Hospital::pluck('name', 'id')->prepend('All Hospitals', '');
        $doctors = \App\Models\Doctor::pluck('doctor_name', 'id')->prepend('All Doctors', '');
        $statuses = [
            '' => 'All Statuses',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'cancelled' => 'Cancelled',
        ];

        return view('livewire.appointment-requests.all-appointment-requests-listing', [
            'data' => $data,
            'hospitals' => $hospitals,
            'doctors' => $doctors,
            'statuses' => $statuses,
            'page' => 'appointment_requests',
        ]);
    }
}