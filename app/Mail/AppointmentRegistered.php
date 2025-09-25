<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        // $appointment = Appointment::latest()->first();
        return $this->subject('Appointment Registered')
            ->view('mails.appointment_registered')
            ->with([
                'data' => [
                    'patient_name' => $this->appointment->patient->name_of_patient,
                    'date' => $this->appointment->date,
                    'time' => $this->appointment->time,
                    'doctor_name' => $this->appointment->doctor->doctor_name,
                    'hospital_name' => $this->appointment->hospital->name,
                ]
            ]);
    }
}
