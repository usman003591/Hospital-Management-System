<?php

namespace App\Mail;

use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\AppointmentRequest;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentRequestRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public AppointmentRequest $appointmentRequest)
    {
        $this->appointmentRequest = $appointmentRequest;
    }

    public function build()
    {
        $patient = Patient::where('cnic_number', $this->appointmentRequest->patient_cnic_number)->first();
        $patientName = $patient ? $patient->name_of_patient : 'N/A';

        return $this->subject('Book Appointment Request Confirmation')
                    ->view('mails.book_appointment_request')
                    ->with([
                        'data' => [
                            'patient_name'   => $patientName,
                            'preferred_date' => $this->appointmentRequest->preferred_date,
                            'preferred_time' => $this->appointmentRequest->preferred_time,
                            'doctor_name'    => optional($this->appointmentRequest->doctor)->doctor_name ?? 'N/A',
                            'hospital_name'  => optional($this->appointmentRequest->hospital)->name ?? 'N/A',
                        ]
                    ]);
    }

    
}
