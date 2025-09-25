<?php

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Invoice;
use App\Models\RoleRights;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RoleRightsAllowed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserLogin;
use App\Http\Controllers\ProfileController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\Setting\BedsController;
use App\Http\Controllers\Setting\BrandController;
use App\Http\Controllers\Setting\FloorController;
use App\Http\Controllers\Setting\RolesController;
use App\Http\Controllers\Setting\RoomsController;
use App\Http\Controllers\Setting\WardsController;
use App\Http\Controllers\Doctor\DoctorsController;
use App\Http\Controllers\Setting\VitalsController;
use App\Models\CdGeneralPhysicalExaminationDetail;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Patient\PatientsController;
use App\Http\Controllers\Invoices\invoicesController;
use App\Http\Controllers\Pharmacy\CashiersController;
use App\Http\Controllers\Setting\DiagnosisController;
use App\Http\Controllers\Setting\HospitalsController;
use App\Http\Controllers\Setting\MedicinesController;
use App\Http\Controllers\Setting\ProcedureController;
use App\Http\Controllers\Pathology\LabTestsController;
use App\Http\Controllers\Setting\ComplaintsController;
use App\Http\Controllers\Setting\DosageFormController;
use App\Http\Controllers\Setting\OPDCounterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Pathology\LabGroupsController;
use App\Http\Controllers\Invoices\LabInvoicesController;
use App\Http\Controllers\Setting\AdmitPatientsController;
use App\Http\Controllers\Users\UserPreferencesController;
use App\Http\Controllers\Department\DepartmentsController;
use App\Http\Controllers\Lab\LabSectionInvoicesController;
use App\Http\Controllers\Pharmacy\OrderStatusesController;
use App\Http\Controllers\Reports\PDFCashDetailsController;
use App\Http\Controllers\Setting\InvestigationsController;
use App\Http\Controllers\Setting\MedicineRoutesController;
use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\DepositSlip\DepositSlipController;
use App\Http\Controllers\Pharmacy\PaymentMethodsController;
use App\Http\Controllers\Setting\ImportOPDModuleController;
use App\Http\Controllers\Setting\ServiceCategoryController;
use App\Http\Controllers\Setting\TreatmentDosageController;
use App\Http\Controllers\ClinicalDiagnosis\CdVitalController;
use App\Http\Controllers\Pathology\LabGroupsDetailController;
use App\Http\Controllers\Prescription\PrescriptionController;
use App\Http\Controllers\Reports\PDFPatientDetailsController;
use App\Http\Controllers\Setting\AppointmentStatusController;
use App\Http\Controllers\Setting\MedicineDurationsController;
use App\Http\Controllers\Setting\TreatmentDurationController;
use App\Http\Controllers\Notification\NotificationsController;
use App\Http\Controllers\Pharmacy\PharmacyInventoryController;
use App\Http\Controllers\Setting\InvestigationTypesController;
use App\Http\Controllers\Appointment\BookAppointmentController;
use App\Http\Controllers\Pharmacy\MedicineCategoriesController;
use App\Http\Controllers\ClinicalDiagnosis\CdDisposalController;
use App\Http\Controllers\Patient\PatientMedicalRecordController;
use App\Http\Controllers\ClinicalDiagnosis\CdDiagnosisController;
use App\Http\Controllers\ClinicalDiagnosis\CdProcedureController;
use App\Http\Controllers\ClinicalDiagnosis\CdTreatmentController;
use App\Http\Controllers\Notification\NotificationUserController;
use App\Http\Controllers\Setting\TreatmentDoseIntervalController;
use App\Http\Controllers\Appointment\AppointmentRequestController;
use App\Http\Controllers\ClinicalDiagnosis\CdComplaintsController;
use App\Http\Controllers\Finance\Summary\FinanceSummaryController;
use App\Http\Controllers\Lab\LabSectionInvoicesDownloadController;
use App\Http\Controllers\Setting\InvoicePaymentStatusesController;
use App\Http\Controllers\ClinicalDiagnosis\CdSnapHistoryController;
use App\Http\Controllers\Patient\PatientExternalDocumentController;
use App\Http\Controllers\ClinicalDiagnosis\CdBriefHistoryController;
use App\Http\Controllers\Pharmacy\PharmacyInvoiceDownloadController;
use App\Http\Controllers\Pharmacy\PharmacyInventoryBatchesController;
use App\Http\Controllers\ClinicalDiagnosis\CdInvestigationsController;
use App\Http\Controllers\Pharmacy\MedicineInventoryStatusesController;
use App\Http\Controllers\ClinicalDiagnosis\ClinicalDiagnosisController;
use App\Http\Controllers\Notification\NotificationCategoriesController;
use App\Http\Controllers\Setting\GeneralPhysicalExaminationsController;
use App\Http\Controllers\Setting\SystematicPhysicalExaminationsController;
use App\Http\Controllers\Investigations\InvestigationCustomFieldsController;
use App\Http\Controllers\ClinicalDiagnosis\CdGeneralPhysicalExaminationController;
use App\Http\Controllers\Finance\Verification\PharmacyInvoiceVerificationController;
use App\Http\Controllers\ClinicalDiagnosis\CdSystematicPhysicalExaminationController;
use App\Http\Controllers\Finance\Verification\PathologyInvoiceVerificationController;
use App\Http\Controllers\Finance\Verification\ServiceCategoriesInvoiceVerificationController;


Route::get('/lab-code', function () {

    $data = [
        'barcodeText' => 'EM-1995-0001',
        'qrCode' => \QrCode::size(60)->generate('https://example.com') // Replace with your URL or data
    ];

    $pdf = Pdf::loadView('documents.lab_code.qr_and_barcode', $data);
    $pdf->setPaper([0, 0, 72, 144], 'portrait');
    $pdf->setOption('isHtml5ParserEnabled', true);

    return $pdf->stream('barcode-label.pdf');

});

Route::get('/check-permissions/{role_id}', function (Request $request) {
    $role = Role::find(id: $request->role_id);
    if ($role) {
        Session::forget('rights');
        Session::put('rights', $role->permissions());
    }

    $rights = Session::get('rights');
    dd($role->name, $rights);

});

Route::prefix('book-appointment')->group(callback: function (): void {

    Route::get('/', [BookAppointmentController::class, 'book_appointment'])->name('patients.book_appointment');
    Route::post('/save', [BookAppointmentController::class, 'save_appointment'])->name('patients.save_appointment');

});

Route::middleware([CheckUserLogin::class])->group(function () {

    //Dashboard Routes start here
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/doctor-dashboard', [DashboardController::class, 'doctor'])->name('doctor.dashboard');
    Route::get('/pharmacy-dashboard', [DashboardController::class, 'pharmacy_dashboard'])->name('pharmacy.dashboard');
    Route::get('/pathology-dashboard', [DashboardController::class, 'pathology_dashboard'])->name('pathology.dashboard');
    Route::get('/finance-dashboard', [DashboardController::class, 'finance_dashboard'])->name('finance.dashboard');
    Route::get('/department-dashboard', [DashboardController::class, 'department_dashboard'])->name('department.dashboard');
    //Dashboard Routes ends here

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile-settings', [ProfileController::class, 'profile_settings'])->name('profile.settings');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('user-preferences')->group(function () {
        Route::post('/change-preferences', [UserPreferencesController::class, 'change_preferences'])->name('user_preferences.change');
    });

    Route::get('role/permissions/{id}', [RolesController::class, 'permissions'])->name('role.permissions');
    Route::post('role/permissions/{id}', [RolesController::class, 'permissions_update'])->name('role.permissions.update');


    Route::prefix('clinical_diagnosis')->group(function () {

        Route::get('/daily-listing', [ClinicalDiagnosisController::class, 'dailyListingRecord'])->name('clinical_diagnosis.dailyListingRecord');
        Route::get('/my-daily-listing', [ClinicalDiagnosisController::class, 'myDailyListingRecord'])->name(name: 'clinical_diagnosis.myDailyListingRecord');
        Route::get('/my-all-listing', [ClinicalDiagnosisController::class, 'myAllListingRecord'])->name(name: 'clinical_diagnosis.myAllListingRecord');
        Route::get('/download-snapshot/{sanpshot_unique_number}', [ClinicalDiagnosisController::class, 'download_sanpshot'])->name('clinical_diagnosis.downlaod_snapshot');
        Route::get('/{id}/preview', [ClinicalDiagnosisController::class, 'previewOPDRecords'])->name('clinical_diagnosis.preview');
        Route::post('/generate-investigations-record/{cd_id}', [ClinicalDiagnosisController::class, 'generate_investigations_record'])->name('clinical_diagnosis.generate_investigations_record');

    });

    Route::prefix('reports')->group(function () {
        //Cash Details Reports
        Route::get('/cash-details-report', [PDFCashDetailsController::class, 'index'])->name('reports.cash_details_report');
        Route::post('/cash-details-report', [PDFCashDetailsController::class, 'store'])->name('cash_details_report.store');
        //Patient Details Reports
        Route::get('/patient-details-prescription-report', [PDFPatientDetailsController::class, 'index'])->name('reports.patient_prescriptions_details_report');
        Route::post('/patient-details-prescription-report', [PDFPatientDetailsController::class, 'store'])->name('patient_prescriptions_details_report.store');
    });

    $modules = [

        'users' => UsersController::class,
        'doctors' => DoctorsController::class,
        'patients' => PatientsController::class,
        'prescriptions' => PrescriptionController::class,
        'roles' => RolesController::class,
        'service_categories' => ServiceCategoryController::class,
        'departments' => DepartmentsController::class,
        'invoice_payment_statuses' => InvoicePaymentStatusesController::class,
        'invoices' => InvoicesController::class,
        'reports' => ReportsController::class,
        'complaints' => ComplaintsController::class,
        'general_physical_examinations' => GeneralPhysicalExaminationsController::class,
        'systematic_physical_examinations' => SystematicPhysicalExaminationsController::class,
        'vitals' => VitalsController::class,
        'treatment_dosage' => TreatmentDosageController::class,
        'treatment_duration' => TreatmentDurationController::class,
        'treatment_dose_interval' => TreatmentDoseIntervalController::class,
        'clinical_diagnosis' => ClinicalDiagnosisController::class,
        'medicines' => MedicinesController::class,
        'medicine_durations' => MedicineDurationsController::class,
        'investigations' => InvestigationsController::class,
        'diagnosis' => DiagnosisController::class,
        'investigation_types' => InvestigationTypesController::class,
        'hospitals' => HospitalsController::class,
        'deposit_slips' => DepositSlipController::class,
        'appointment_requests' => AppointmentRequestController::class,
        'book_appointments' => BookAppointmentController::class,
        'appointments' => AppointmentController::class,
        'cashiers' => CashiersController::class,
        'medicine_categories' => MedicineCategoriesController::class,
        'medicine_inventory_statuses' => MedicineInventoryStatusesController::class,
        'order_statuses' => OrderStatusesController::class,
        'payment_methods' => PaymentMethodsController::class,
        'brands' => BrandController::class,
        'wards' => WardsController::class,
        'beds' => BedsController::class,
        'notifications' => NotificationsController::class,
        'notification_categories' => NotificationCategoriesController::class,
        'rooms' => RoomsController::class,
        'admit_patients' => AdmitPatientsController::class,
        'medicine_routes' => MedicineRoutesController::class,
        'appointment_statuses' => AppointmentStatusController::class,
        'floors' => FloorController::class,
        'dosage_forms' => DosageFormController::class,
        'procedures' => ProcedureController::class,
        'opd_counter' => OPDCounterController::class,
        'lab_groups' => LabGroupsController::class,
        'lab_invoices' => LabSectionInvoicesController::class,
    ];

    Route::prefix('pathology')->group(function () {
        Route::get('/check-qr-code/{lab_group_number}', [LabGroupsController::class, 'check_qr_code'])->name('pathology.check_qr_code');
    });

    Route::prefix('pharmacy')->group(function () {
        Route::prefix('inventory')->group(function () {

            Route::get('/list', [PharmacyInventoryController::class, 'index'])->name('pharmacy.list_pharmacy_inventory');
            Route::get('/create', [PharmacyInventoryController::class, 'create'])->name('pharmacy.create_pharmacy_inventory');
            Route::get('/{inventory_id}/edit', [PharmacyInventoryController::class, 'edit'])->name('pharmacy.edit_pharmacy_inventory');
            Route::post('/', [PharmacyInventoryController::class, 'store'])->name('pharmacy.store_pharmacy_inventory');
            Route::patch('/{inventory_id}/update', [PharmacyInventoryController::class, 'update'])->name('pharmacy.update_pharmacy_inventory');
            Route::delete('/{inventory_id}', [PharmacyInventoryController::class, 'destroy'])->name('pharmacy.destroy_pharmacy_inventory');

            Route::prefix('batches')->group(function () {

                Route::get('/{medicine_id}/list', [PharmacyInventoryBatchesController::class, 'index'])->name('pharmacy.list_pharmacy_inventory_batches');
                Route::get('/{medicine_id}/batch/{batch_id}/barcode', [PharmacyInventoryBatchesController::class, 'downloadBarCode'])->name('pharmacy.download_pharmacy_inventory_batch_code');
            });
        });
    });

    Route::prefix('finance')->group(function () {

        Route::get('/verification/pathology', [PathologyInvoiceVerificationController::class, 'index'])->name('finance.pathology_invoices_verification');
        Route::get('/verification/pharmacy', [PharmacyInvoiceVerificationController::class, 'index'])->name('finance.pharmacy_invoices_verification');
        Route::get('/verification/service_categories', [ServiceCategoriesInvoiceVerificationController::class, 'index'])->name('finance.service_categories_invoices_verification');

        Route::get('/verification/pathology/{id}/detail', [PathologyInvoiceVerificationController::class, 'show_details'])->name('finance.pathology_invoices_verification_detail');
        Route::get('/verification/pharmacy/{id}/detail', [PharmacyInvoiceVerificationController::class, 'show_details'])->name('finance.pharmacy_invoices_verification_detail');
        Route::get('/verification/service_categories/{id}/detail', [ServiceCategoriesInvoiceVerificationController::class, 'show_details'])->name('finance.service_categories_invoices_verification_detail');

        Route::prefix('download')->group(function () {

            Route::get('/pathology/{id}', [PathologyInvoiceVerificationController::class, 'download_pathology_invoice'])->name('finance.download_pathology_invoice');
            Route::get('/pharmacy/{id}', [PharmacyInvoiceVerificationController::class, 'download_pharmacy_invoice'])->name('finance.download_pharmacy_invoice');
            Route::get('/service_categories/{id}', [ServiceCategoriesInvoiceVerificationController::class, 'download_service_category_invoice'])->name('finance.download_service_category_invoice');

        });

        Route::get('/summary', [FinanceSummaryController::class, 'getSummary'])->name('finance.get_summary');
        Route::post('/summary', [FinanceSummaryController::class, 'DownloadSummary'])->name('finance.download_summary');

    });
    //Download Slips

    Route::prefix('pharmacy-invoices')->group(function () {
        Route::get('/download/{id}', [PharmacyInvoiceDownloadController::class, 'download_invoice'])->name('pharmacy-invoices.download');
    });
    Route::prefix('prescriptions')->group(function () {
        Route::get('/download/{id}', [PrescriptionController::class, 'download_prescription'])->name('prescriptions.downlaod');
    });
    Route::prefix('opd-slip')->group(function () {
        Route::get('/download/{id}', [ClinicalDiagnosisController::class, 'download_opd_slip'])->name('clinical_diagnosis.download');
    });
    Route::prefix('invoices')->group(function () {
        Route::get('/download/{id}', [invoicesController::class, 'download_invoice'])->name('invoices.downlaod');
    });
    Route::prefix('lab_invoices')->group(function () {
        Route::get('/download/{id}', [LabSectionInvoicesController::class, 'download_invoice'])->name('lab_invoices.download');
    });
    Route::prefix('lab-invoices')->group(function () {
        Route::get('/download/{id}', [LabSectionInvoicesController::class, 'download_invoice'])->name('lab-invoices.download');
    });
    Route::prefix('deposit_slips')->group(function () {
        Route::get('/download/{id}', [DepositSlipController::class, 'downloadSlip'])->name('deposit_slips.download');
    });
    Route::prefix('patients')->group(function () {
        Route::get('/download/{id}', [PatientsController::class, 'download_visiting_card'])->name('patients.downlaod');
        Route::get('/check-cnic', [PatientsController::class, 'checkCnic'])->name('patients.checkCnic');
    });

    foreach ($modules as $key => $moduleClass) {

        Route::get($key, [$moduleClass, 'index'])->name($key . '.index');
        Route::post($key . '/change-status', [$moduleClass, 'change_status'])->name($key . '.change_status');
        Route::get($key . '/create', [$moduleClass, 'create'])->name($key . '.create');
        Route::post($key . '/store', [$moduleClass, 'store'])->name($key . '.store');
        Route::get($key . '/{id}/edit', [$moduleClass, 'edit'])->name($key . '.edit');
        Route::patch($key . '/{id}/update', [$moduleClass, 'update'])->name($key . '.update');
        Route::delete($key . '/{id}', [$moduleClass, 'delete'])->name($key . '.delete');
        Route::get($key . '/export', [$moduleClass, 'export'])->name($key . '.export');
        Route::get($key . '/view', [$moduleClass, 'view'])->name($key . '.view');

    }

    Route::prefix('lab_groups')->group(function () {

        //Detail Page
        Route::post('add-lab-group-data', [LabGroupsController::class, 'add_lab_group'])->name('lab_groups.add_lab_group');
        Route::get('{id}/detail', [LabGroupsDetailController::class, 'detail'])->name('lab_groups.detail');

        Route::get('{id}/download-result', [LabGroupsDetailController::class, 'download_result'])->name('lab_groups.download_result');
        Route::get('{id}/download-patient-receipt', [LabGroupsDetailController::class, 'download_patient_receipt'])->name('lab_groups.download_patient_receipt');
        Route::get('{id}/lab-code', [LabGroupsDetailController::class, 'lab_code'])->name('lab_groups.lab_code');
        Route::get('{id}/lab_tests', [LabGroupsDetailController::class, 'lab_tests'])->name('lab_groups.lab_tests');

        Route::get('{id}/patient_lab_test', [LabGroupsDetailController::class, 'GetPatientLabTests'])->name('lab_groups.patient_lab_tests');
        Route::get('{id}/lab_tests/{test_id}/details', [LabGroupsDetailController::class, 'lab_group_test_details'])->name('lab_groups.lab_tests.details');
        Route::post('{id}/lab_tests/{test_id}/details', [LabGroupsDetailController::class, 'save_lab_group_test_details'])->name('lab_groups.lab_tests.save_details');

    });

    Route::prefix('lab_tests')->group(function () {

        Route::post('change-status', [LabTestsController::class, 'change_status'])->name('lab_tests.change_status');
        Route::post('{lab_group_id}/add', [LabTestsController::class, 'save_lab_group_investigations'])->name('lab_tests.add_investigations');
        Route::get('{test_id}/preview', [LabTestsController::class, 'lab_test_download'])->name('lab_tests.download');
        Route::delete('{id}', [LabTestsController::class, 'delete'])->name('lab_tests.delete');

    });
    // ... existing routes ...

    Route::prefix('investigation_custom_fields')->group(function () {
        Route::get('/', [InvestigationCustomFieldsController::class, 'index'])->name('investigation_custom_fields.index');
        Route::post('/change-status', [InvestigationCustomFieldsController::class, 'change_status'])->name('investigation_custom_fields.change_status');
        Route::get('/create', [InvestigationCustomFieldsController::class, 'create'])->name('investigation_custom_fields.create');
        Route::post('/store', [InvestigationCustomFieldsController::class, 'store'])->name('investigation_custom_fields.store');
        Route::get('/{id}/edit', [InvestigationCustomFieldsController::class, 'edit'])->name('investigation_custom_fields.edit');
        Route::patch('/{id}/update', [InvestigationCustomFieldsController::class, 'update'])->name('investigation_custom_fields.update');
        Route::delete('/{id}', [InvestigationCustomFieldsController::class, 'delete'])->name('investigation_custom_fields.delete');
        Route::get('/{id}', [InvestigationCustomFieldsController::class, 'show'])->name('investigation_custom_fields.show');
        Route::post('/{id}/update-attached', [InvestigationCustomFieldsController::class, 'updateAttachedFields'])->name('investigation_custom_fields.update-attached');
    });

    Route::get('beds/get-rooms', [BedsController::class, 'getRooms'])->name('beds.getRooms');

    Route::prefix('patients')->group(function () {
        Route::get('/{id}/overview', [PatientsController::class, 'show'])->name('patients.detail_page');
        Route::get('/{id}/opd-record', [PatientsController::class, 'opd_record'])->name('patients.opd_record');
        Route::get('/{id}/invoice-record', [PatientsController::class, 'invoice_record'])->name('patients.invoice_record');
        Route::get('/{id}/documents-list', [PatientsController::class, 'documents_list'])->name('patients.documents_list');
        Route::get('/{id}/brief_histories', [PatientsController::class, 'brief_histories'])->name('patients.brief_histories');
        Route::get('/{id}/lab-groups', [PatientsController::class, 'lab_groups'])->name('patients.lab_groups');
        Route::get('/download/{id}', [PatientsController::class, 'download_visiting_card'])->name('patients.downlaod');
    });

    Route::prefix('appointments')->group(function () {
        Route::get('/all', [AppointmentController::class, 'logged_in_doctor_appointments'])->name('appointments.logged_in_doctor_appointments');
        Route::get('/daily', [AppointmentController::class, 'logged_in_doctor_appointments_daily'])->name('appointments.logged_in_doctor_appointments_daily');
    });

    Route::prefix('appointment_requests')->group(function () {
        Route::get('/{id}/detail', [AppointmentRequestController::class, 'show'])->name('appointment_requests.show');
    });

    Route::prefix('investigations')->group(function () {
        Route::get('/{id}/details', [InvestigationsController::class, 'details'])->name('investigations.details');
        Route::get('/{id}/investigation_fields', [InvestigationsController::class, 'show'])->name('investigations.show');
    });

    Route::post('/investigations/detach', [InvestigationsController::class, 'detachAttachedField'])->name('investigations.detach');
    Route::post('/investigations/attach', [InvestigationsController::class, 'attachField'])->name('investigations.attach');

    Route::get('/global-search', [GlobalSearchController::class, 'search'])->name('global.search');
    Route::get('/patient-medication-record', [PatientMedicalRecordController::class, 'medication_record'])->name('patient_medication_record.index');
    Route::get('/patient-medicines-detail/{id}', [PatientMedicalRecordController::class, 'medicine_record_in_detail'])->name('medicine_record_in_detail.detail');

    //Notifications
    Route::get('/notifications/view', [NotificationUserController::class, 'index'])->name('notifications.view');
    Route::post('/notifications/{id}/read', [NotificationUserController::class, 'markAsRead'])->name('notifications.read');

    //Import OPD module data
    Route::get('/import-opd-data', [ImportOPDModuleController::class, 'import'])->name('import_opd_data');
    Route::post('/import-opd-complaints', [ImportOPDModuleController::class, 'import_opd_complaints'])->name('opd_complaints.import');
    Route::post('/import-opd-gpe', [ImportOPDModuleController::class, 'import_opd_gpe'])->name('opd_gpe.import');
    Route::post('/import-opd-spe', [ImportOPDModuleController::class, 'import_opd_spe'])->name('opd_spe.import');
    Route::post('/import-opd-investigations', [ImportOPDModuleController::class, 'import_opd_investigations'])->name('opd_investigations.import');
    Route::post('/import-opd-diagnosis', [ImportOPDModuleController::class, 'import_opd_diagnosis'])->name('opd_diagnosis.import');
    Route::post('/import-opd-treatment', [ImportOPDModuleController::class, 'import_opd_treatment'])->name('opd_treatment.import');
    Route::post('/import-opd-medicalcamp-data', [ImportOPDModuleController::class, 'import_medical_camp_data'])->name('opd_medical_camp.import');

    Route::get('api/fetch-complaints/{complaint_id}', [ComplaintsController::class, 'fetchComplaints']);
    Route::get('api/fetch-general-physical-examinations/{gpe_id}', [GeneralPhysicalExaminationsController::class, 'fetchGPEs']);
    Route::get('api/fetch-systematic-physical-examinations/{spe_id}', [SystematicPhysicalExaminationsController::class, 'fetchSPEs']);
    Route::get('api/fetch-diagnosis/{diagnosis_id}', [DiagnosisController::class, 'fetchDiagnosis']);

    Route::get('/search-diagnosis', [DiagnosisController::class, 'search'])->name('search.diagnosis');
    Route::get('/search-medicines', [MedicinesController::class, 'search'])->name('search.medicines');

    Route::get('api/fetch-user-hospitals/', [ProfileController::class, 'fetchUserHospitals'])->name('user_preference_hospitals');
    Route::get('api/fetch-disposal-data/', [ClinicalDiagnosisController::class, 'fetch_disposal_data'])->name('fetch_disposal_data');
    Route::get('api/fetch-hospital-doctors/{hospital_id}', [HospitalsController::class, 'fetchHospitalDoctors'])->name('fetch_hospital_doctors');
    Route::get('api/fetch-patient-history/clinical_diagnosis_id/{clinical_diagnosis_id}', [ClinicalDiagnosisController::class, 'fetchPatientHistory'])->name('fetch_patient_history');

    //Data Tables
    Route::get('api/fetch-specific-hospital-invoices/', [invoicesController::class, 'fetchSpecificHospitalInvoices'])->name('specific_hospital_invoices');
    Route::get('api/fetch-specific-lab-groups/', [LabGroupsController::class, 'fetchSpecificLabGroups'])->name('specific_lab_groups');
    Route::get('api/fetch-specific-clinical-diagnosis/', [ClinicalDiagnosisController::class, 'fetchSpecificClinicalDiagnosis'])->name('specific_clinical_diagnosis');
    Route::get('api/fetch-specific-prescriptions/', [PrescriptionController::class, 'fetchSpecificPrescriptions'])->name('specific_prescriptions');
    Route::get('api/fetch-specific-appointments/', [AppointmentController::class, 'fetchSpecificAppointments'])->name('specific_appointments');
    Route::get('api/fetch-specific-deposit-slips/', [DepositSlipController::class, 'fetchSpecificDepositSlips'])->name('specific_deposit_slips');

    Route::prefix('clinical_diagnosis')->group(function () {

        Route::get('/{id}/detail', [ClinicalDiagnosisController::class, 'detail_form'])->name('clinical_diagnosis.detail_form');
        Route::get('/{id}/vitals', [ClinicalDiagnosisController::class, 'vitals_form'])->name('clinical_diagnosis.vitals_form');
        Route::get('/{id}/investigations', [ClinicalDiagnosisController::class, 'investigations_form'])->name('clinical_diagnosis.investigations_form');

        Route::post('{cd_id}/get-snapshot', [CdSnapHistoryController::class, 'get_snapshot'])->name('clinical_diagnosis.get_snapshot');

        Route::match(['post', 'put'], '{cd_id}/store-complaints', [CdComplaintsController::class, 'store'])->name('clinical_diagnosis.store_complaints');
        Route::match(['post', 'put'], '{cd_id}/store-brief-history', [CdBriefHistoryController::class, 'store'])->name('clinical_diagnosis.store_brief_history');
        Route::match(['post', 'put'], '{cd_id}/store-vitals', [CdVitalController::class, 'store'])->name('clinical_diagnosis.store_vitals');
        Route::match(['post', 'put'], '{cd_id}/store-registration-vitals', [CdVitalController::class, 'registration_vitals_form'])->name('clinical_diagnosis.registration_vitals_form');
        Route::match(['post', 'put'], '{cd_id}/store-investigations', [CdInvestigationsController::class, 'store'])->name('clinical_diagnosis.store_investigations');
        Route::match(['post', 'put'], '{cd_id}/store-gpe', [CdGeneralPhysicalExaminationController::class, 'store'])->name('clinical_diagnosis.store_gpe');
        Route::match(['post', 'put'], '{cd_id}/store-spe', [CdSystematicPhysicalExaminationController::class, 'store'])->name('clinical_diagnosis.store_spe');
        Route::match(['post', 'put'], '{cd_id}/store-diagnosis', [CdDiagnosisController::class, 'store'])->name('clinical_diagnosis.store_diagnosis');
        Route::match(['post', 'put'], '{cd_id}/store-procedure', [CdProcedureController::class, 'store'])->name('clinical_diagnosis.store_procedure');
        Route::match(['post', 'put'], '{cd_id}/store-treatment', [CdTreatmentController::class, 'store'])->name('clinical_diagnosis.store_treatment');
        Route::match(['post', 'put'], '{cd_id}/store-snap-history', [CdSnapHistoryController::class, 'store'])->name('clinical_diagnosis.store_snap_history');
        Route::match(['post', 'put'], '{cd_id}/store-disposal', [CdDisposalController::class, 'store'])->name('clinical_diagnosis.store_disposal');

    });


    Route::post('/patients/documents', [PatientExternalDocumentController::class, 'store'])->name('patient_external_documents.store');
    Route::get('/patients/documents/{document}/preview', [PatientExternalDocumentController::class, 'previewDocs'])->name('patient_external_documents.preview');
});



Route::get('/test-invoice', function () {

    try {
        $cd_id = 2;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
require __DIR__ . '/auth.php';


// Route::get('/php-info', function () {
//     phpinfo();
// });

Route::get('/hello', function () {

    $data = [
        'title' => 'Welcome to Laravel PDF',
        'date' => date('m/d/Y')
    ];

    $pdf = Pdf::loadView('documents.test_slip', $data)
        ->setPaper('a4', 'landscape');
    return $pdf->stream('invoice.pdf');


    return view('documents.test_slip');
});
Route::get('/helloOne', function () {

    $data = [
        'title' => 'Welcome to Laravel PDF',
        'date' => date('m/d/Y')
    ];

    $pdf = Pdf::loadView('documents.test_slip_one', $data);
    return $pdf->stream('invoice.pdf');


    return view('documents.test_slip_one');
});

Route::get('/idc', function () {

    $data = [
        'title' => 'Welcome to Laravel PDF',
        'date' => date('m/d/Y')
    ];

    $pdf = Pdf::loadView('documents.IDC_slip', $data);
    return $pdf->stream('invoice.pdf');


    return view('documents.IDC_slip');
});
