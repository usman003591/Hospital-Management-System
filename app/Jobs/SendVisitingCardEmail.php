<?php

namespace App\Jobs;

use App\Mail\PatientVisitingCardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendVisitingCardEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $patient;
    protected $visitingCardPath;

    public function __construct($patient, $visitingCardPath)
    {
        $this->patient = $patient;
        $this->visitingCardPath = $visitingCardPath;
    }

    public function handle()
    {
        try {
            Log::info('Starting to send visiting card email', [
                'patient_id' => $this->patient->id,
                'email' => $this->patient->email,

            ]);

            $data = [
                'title' => 'Download Visitor Card',
                'description' => 'Dear visitor' . $this->patient->name_of_patient . ' please download your visitor card in this email and bring it on your every visit to SIRM',
                'thanks' => 'Thanks for visiting CSC SIRM (Smart Institue of Rehablitation & Medicine)'
            ];

            Mail::to($this->patient->email)
                ->send(new PatientVisitingCardMail($this->patient, $this->visitingCardPath, $data));

            Log::info('Successfully sent visiting card email', [
                'patient_id' => $this->patient->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send visiting card email', [
                'error' => $e->getMessage(),
                'patient_id' => $this->patient->id
            ]);
            throw $e;
        }
    }
}
