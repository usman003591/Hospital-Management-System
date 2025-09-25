<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use DB;

class InvoiceSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoices = Invoice::orderBy('id')->get();

        foreach ($invoices as $invoice) {
            $invoice->invoice_sequence = null;
            $invoice->save();
        }

       // Define hospital abbreviations
        $hospitalAbbr = [
            1 => 'SIRM',
            2 => 'SCH',
        ];

        // Track sequence counters per hospital
        $hospitalCounters = [];

        // Get all invoices without a sequence
        $invoices = Invoice::whereNull('invoice_sequence')->whereDate('created_at', '>=', '2025-06-14')->orderBy('id')->get();

        foreach ($invoices as $invoice) {
            $hospitalId = $invoice->hospital_id;
            $prefix = 'IN';

            if (!$prefix || !isset($hospitalAbbr[$hospitalId])) {
                continue; // Skip if missing receipt number or unknown hospital
            }

            // Initialize or increment the counter per hospital
            if (!isset($hospitalCounters[$hospitalId])) {
                $hospitalCounters[$hospitalId] = 1;
            } else {
                $hospitalCounters[$hospitalId]++;
            }

            // Format: <receipt_number>-<abbreviation>-<counter>
            $sequence = sprintf(
                '%s-%s-%d',
                $hospitalAbbr[$hospitalId],
                $prefix,
                $hospitalCounters[$hospitalId]
            );

            // Save sequence to invoice
            $invoice->invoice_sequence = $sequence;
            $invoice->save();
        }

        echo "Invoice sequences updated using receipt numbers.\n";
    }
}
