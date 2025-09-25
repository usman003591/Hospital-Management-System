<?php

namespace App\Livewire\Appointments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appointment;

class AppointmentsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $hospital_id = '';
    public $appointment_status_id = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'hospital_id' => ['except' => ''],
        'appointment_status_id' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'hospital_id', 'appointment_status_id']);
        $this->resetPage();
    }

    public function render()
{
    $query = Appointment::query()
        ->select('appointment.*') 
        ->with(['hospital', 'appointmentStatus', 'patient', 'doctor']) 
        ->when($this->q !== '', function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->whereHas('patient', function ($q) {
                    $q->where('name_of_patient', 'ILIKE', "%{$this->q}%")
                    ->orWhere('patient_mr_number', 'ILIKE', "%{$this->q}%")
                    ->orWhere('cell', 'ILIKE', "%{$this->q}%");
                })
                ->orWhereHas('doctor', function ($q) {
                    $q->where('doctor_name', 'ILIKE', "%{$this->q}%");
                })
                ->orWhereHas('appointmentStatus', function ($q) {
                    $q->where('name', 'ILIKE', "%{$this->q}%");
                });
            });

        })

    ->when($this->hospital_id, fn($query) => $query->where('appointment.hospital_id', $this->hospital_id))
    ->when($this->appointment_status_id, fn($query) => $query->where('appointment.appointment_status_id', $this->appointment_status_id));

    $data = $query->orderBy('appointment.created_at', 'desc')
        ->paginate(10);

    $hospitals = \App\Models\Hospital::pluck('name', 'id')->prepend('All Hospitals', '');
    $appointmentStatuses = \App\Models\AppointmentStatus::pluck('name', 'id')->prepend('All Statuses', '');

    return view('livewire.appointments.appointments-listing', [
        'data' => $data,
        'hospitals' => $hospitals,
        'appointmentStatuses' => $appointmentStatuses,
        'page' => 'appointments',
    ]);
}

}