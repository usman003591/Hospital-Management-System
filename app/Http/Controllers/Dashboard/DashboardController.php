<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\LabInvoice;
use App\Models\PosInvocie;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\UserPreferences;
use App\Models\ClinicalDiagnosis;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index () {

        // if(\Auth::check()) {
        //     return redirectDashboardLinkByRole();
        // }

        if(!checkPersonPermission('view_opd_dashboard_69')) {
            return ErrorMessage(403);
        }

        $daily_stats = Invoice::getDailyInvoiceStatsData();
        $weekly_stats = Invoice::getWeeklyInvoiceStatsData();
        $monthly_stats = Invoice::getMonthlyInvoiceStatsData();

        $stats['daily']['total_amount'] = $daily_stats['total_amount'];
        $stats['daily']['received_amount'] = $daily_stats['received_amount'];
        $stats['daily']['discount_amount'] = $daily_stats['discount_amount'];

        $stats['weekly']['total_amount'] = $weekly_stats['total_amount'];
        $stats['weekly']['received_amount'] = $weekly_stats['received_amount'];
        $stats['weekly']['discount_amount'] = $weekly_stats['discount_amount'];

        $stats['monthly']['total_amount'] = $monthly_stats['total_amount'];
        $stats['monthly']['received_amount'] = $monthly_stats['received_amount'];
        $stats['monthly']['discount_amount'] = $monthly_stats['discount_amount'];

        $data['doctors_count'] =  Doctor::getDoctorsCount();
        $data['patients_count'] = Patient::getPatientsCount();
        $data['prescriptions_count'] = Prescription::getPrescriptionsCount();
        $data['invoices_count'] = Invoice::getInvoicesCount();

        $preferences = UserPreferences::getPreferences();
        return view('dashboard.index', compact('preferences','data','stats'));
    }

    public function doctor () {

        if(!checkPersonPermission('view_doctor_dashboard_75')) {
               return ErrorMessage(403);
        }
        // dd(auth()->user());
        try {

        $d =  ClinicalDiagnosis::getDoctorStats();
        $preferences = UserPreferences::getPreferences();
        $doctorPanelValue = checkDoctorPanelVal();
        $redirect_value = giveRedirectValue();

        // dd($redirect_value);
        // dd($doctorPanelValue);

        return view('dashboard.doctor.index', compact('preferences','d','doctorPanelValue','redirect_value'));

        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function pharmacy_dashboard () {

        if(!checkPersonPermission('view_pharmacy_dashboard_73')) {
               return ErrorMessage(403);
        }

        $daily_stats = PosInvocie::getDailyInvoiceStatsData();
        $weekly_stats = PosInvocie::getWeeklyInvoiceStatsData();
        $monthly_stats = PosInvocie::getMonthlyInvoiceStatsData();

        $stats['daily']['total_amount'] = $daily_stats['total_amount'];
        $stats['daily']['received_amount'] = $daily_stats['received_amount'];
        $stats['daily']['discount_amount'] = $daily_stats['discount_amount'];

        $stats['weekly']['total_amount'] = $weekly_stats['total_amount'];
        $stats['weekly']['received_amount'] = $weekly_stats['received_amount'];
        $stats['weekly']['discount_amount'] = $weekly_stats['discount_amount'];

        $stats['monthly']['total_amount'] = $monthly_stats['total_amount'];
        $stats['monthly']['received_amount'] = $monthly_stats['received_amount'];
        $stats['monthly']['discount_amount'] = $monthly_stats['discount_amount'];

        $preferences = UserPreferences::getPreferences();
        return view('dashboard.pharmacy.index', compact('preferences','stats'));
    }

    public function pathology_dashboard () {

        if(!checkPersonPermission('view_pathology_dashboard_74')) {
               return ErrorMessage(403);
        }

        $daily_stats = LabInvoice::getDailyInvoiceStatsData();
        $weekly_stats = LabInvoice::getWeeklyInvoiceStatsData();
        $monthly_stats = LabInvoice::getMonthlyInvoiceStatsData();

        $stats['daily']['total_amount'] = $daily_stats['total_amount'];
        $stats['daily']['received_amount'] = $daily_stats['received_amount'];
        $stats['daily']['discount_amount'] = $daily_stats['discount_amount'];

        $stats['weekly']['total_amount'] = $weekly_stats['total_amount'];
        $stats['weekly']['received_amount'] = $weekly_stats['received_amount'];
        $stats['weekly']['discount_amount'] = $weekly_stats['discount_amount'];

        $stats['monthly']['total_amount'] = $monthly_stats['total_amount'];
        $stats['monthly']['received_amount'] = $monthly_stats['received_amount'];
        $stats['monthly']['discount_amount'] = $monthly_stats['discount_amount'];

        $preferences = UserPreferences::getPreferences();
        return view('dashboard.pathology.index', compact('preferences','stats'));

    }
    public function finance_dashboard () {

        if(!checkPersonPermission('view_finance_dashboard_76')) {
               return ErrorMessage(403);
        }

        $services_invoice_stats = Invoice::getInvoicesStatsForFinance();
        $pathology_invoice_stats = LabInvoice::getInvoicesStatsForFinance();
        $pharmacy_invoice_stats = PosInvocie::getInvoicesStatsForFinance();
        $preferences = UserPreferences::getPreferences();

        return view('dashboard.finance.index', compact('preferences','services_invoice_stats','pathology_invoice_stats','pharmacy_invoice_stats'));
    }
}
