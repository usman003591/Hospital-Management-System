<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PatientVisitingCardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $visitingCardPath;
    public $data;

    public function __construct($patient, $visitingCardPath, $data)
    {
        $this->patient = $patient;
        $this->visitingCardPath = $visitingCardPath;
        $this->data = $data;
    }

    public function build()
    {
        try {

            Log::info('Attempting to build email with visiting card', [
                'patient_id' => $this->patient->id,
                'file_path' => $this->visitingCardPath
            ]);

            return $this->subject('Your Patient Visiting Card')
            ->view('mails.send_visitor_card',$this->data)
                    ->attach($this->visitingCardPath, [
                        'as' => 'visiting_card.pdf',
                        'mime' => 'application/pdf'
                    ]);


                    // return $this->from('no-reply@cms.com')
                    // ->subject('You have recieved a password change request')
                    // ->view('mails.send_rseet_email', $this->data);



        } catch (\Exception $e) {
            Log::error('Error building visiting card email', [
                'error' => $e->getMessage(),
                'patient_id' => $this->patient->id
            ]);
            throw $e;
        }
    }
}
