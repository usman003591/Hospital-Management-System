<?php

namespace App\Livewire\Finance\Summary;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\LabInvoice;
use App\Models\PosInvocie;
use App\Models\UserPreferences;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateSummary extends Component
{
    public $invoice_type;
    public $hospital_id;
    public $summary_year;
    public $summaryData = [];

    public function render()
    {
        $hospitals = Hospital::select('id', 'name')->get();
        return view('livewire.finance.summary.generate-summary', compact('hospitals'));
    }


    public function exportPdf()
    {
        $preferences = UserPreferences::getPreferences();
        $hospital_id = $preferences['preference']['hospital_id'];
        $hospital = Hospital::find($hospital_id);

        $pdf = Pdf::loadView('documents.finance.summary-pdf', [
            'hospital' => $hospital,
            'invoice_type' => $this->invoice_type,
            'summary_year' => $this->summary_year,
            'summaryData'  => $this->summaryData
        ]);


        return response()->streamDownload(
            fn() => print($pdf->output()),
            "summary-{$this->summary_year}.pdf"
        );
    }

    public function generateSummary()
    {
        // Ensure all required fields are selected
        if (!$this->invoice_type || !$this->hospital_id || !$this->summary_year) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Please select all filters!']);
            return;
        }

        // Prepare empty arrays for 12 months
        $months = range(1, 12);
        $net = $discount = $received = $receivable = array_fill(0, 12, 0);

        // Switch for invoice type
        switch ($this->invoice_type) {
            case 'pharmacy':

                   $query = PosInvocie::when($this->summary_year, function ($q) {
                        $q->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$this->summary_year]);
                    })
                    ->when($this->hospital_id, fn($q) => $q->where('hospital_id', $this->hospital_id))
                    ->selectRaw("
                        EXTRACT(MONTH FROM created_at)::int as month,
                        ROUND(SUM(final_amount::numeric), 0) as received,
                        ROUND(SUM(final_amount::numeric), 0) as net,
                        ROUND(SUM((final_amount::numeric) / (1 - (discount_percentage::numeric / 100))), 0) as receivable,
                        ROUND(SUM((final_amount::numeric) / (1 - (discount_percentage::numeric / 100)) - final_amount::numeric), 0) as discount
                    ")
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();

                break;

            case 'pathology':

                $query = LabInvoice::when($this->summary_year, function ($q) {
                        $q->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$this->summary_year]);
                    })
                    ->when($this->hospital_id, fn($q) => $q->where('hospital_id', $this->hospital_id))
                    ->selectRaw("
                        EXTRACT(MONTH FROM created_at)::int as month,
                        ROUND(SUM(discount_amount::numeric), 0) as discount,
                        ROUND(SUM(amount_received::numeric), 0) as received,
                        ROUND(SUM(net_amount::numeric), 0) as net,
                        ROUND(SUM(total_amount::numeric), 0) as receivable
                    ")
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();


                break;

            case 'services':
            $query = Invoice::when($this->summary_year, function ($q) {
                        $q->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$this->summary_year]);
                    })
                    ->when($this->hospital_id, fn($q) => $q->where('hospital_id', $this->hospital_id))
                    ->selectRaw("
                        EXTRACT(MONTH FROM created_at)::int as month,
                        ROUND(SUM(discount_amount::numeric), 0) as discount,
                        ROUND(SUM(amount_received::numeric), 0) as received,
                        ROUND(SUM(net_amount::numeric), 0) as net,
                        ROUND(SUM(total_amount::numeric), 0) as receivable
                    ")
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
                break;

            default:
                $query = collect();
                break;
        }

        // Map results into monthly arrays
        foreach ($query as $row) {
            $index = $row->month - 1;
            $net[$index] = $row->net;
            $discount[$index] = $row->discount;
            $received[$index] = $row->received;
            $receivable[$index] = $row->receivable;
        }

        // Save for blade
        $this->summaryData = [
            'net'        => $net,
            'discount'   => $discount,
            'received'   => $received,
            'receivable' => $receivable,
        ];
    }
}
