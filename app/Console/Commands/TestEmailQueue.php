<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendPatientVisitingCard;
use App\Models\Patient;

class TestEmailQueue extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test email queue system';

    public function handle()
    {
        $this->info('Testing email queue...');

        // Create a test patient
        $patient = Patient::first();

        if (!$patient) {
            $this->error('No patient found in database');
            return;
        }

        // Dispatch test job
        SendPatientVisitingCard::dispatch($patient, 'test/path/to/visiting-card.pdf')
            ->onQueue('emails');

        $this->info('Test email job dispatched. Check queue worker logs.');
    }
}
