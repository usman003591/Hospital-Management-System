<?php

use App\Models\Department;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\LabInvoice;
use App\Models\PosInvocie;
use App\Models\UserPreferences;
function getAssetsURLs($part = '')
{
    return url('assets/' . $part);
}

function getAssetsFileURLs($part = '')
{
    return url('src/' . $part);
}

function d($data, $ext = true)
{
    echo "<pre>";
    print_r($data);
    if ($ext)
        exit;
}

function generateIncrementedCnic()
{
    $lastPatient = Patient::where('has_cnic', false)
        ->whereNotNull('cnic_number')
        ->orderBy('cnic_number', 'desc')
        ->first();
    $baseCnic = $lastPatient ? $lastPatient->cnic_number : '11111-1111111-1';
    do {
        $numericValue = (int) str_replace('-', '', $baseCnic);
        $numericValue++;
        $padded = str_pad($numericValue, 13, '0', STR_PAD_LEFT);
        $newCnic = substr($padded, 0, 5) . '-' .
            substr($padded, 5, 7) . '-' .
            substr($padded, 12, 1);
        $baseCnic = $newCnic;

    } while (Patient::where('cnic_number', $newCnic)->exists());
    return $baseCnic;
}

function generateLabSequenceInvoice($prefix)
{

    $prefix = 'LAB';
    $preferences = UserPreferences::getPreferences();
    $hospitalId = $preferences['preference']['hospital_id'];

    $lastInvoice = LabInvoice::where('hospital_id', $hospitalId)
        ->whereNotNull('invoice_sequence')
        ->orderByDesc('id') // or orderBy('created_at', 'desc')
        ->first();

    $last_sequence = isset($lastInvoice->invoice_sequence) ? $lastInvoice->invoice_sequence : null;
    $sequence_number = 0;

    if (preg_match('/-(\d+)$/', $last_sequence, $matches)) {
        $sequence_number = (int) $matches[1];
    } else {
        $sequence_number = 0;
    }

    $sequence_number++; // Increment the sequence number
    $hospital_abbreivation = null;

    switch ($hospitalId) {
        case 1:
            $hospital_abbreivation = 'SIRM';
            break;
        case 2:
            $hospital_abbreivation = 'SCH';
            break;
        default:
            $hospital_abbreivation = 'SIRM';
            break;
    }

    $new_invoice_sequencr = $hospital_abbreivation . '-' . $prefix . '-' . $sequence_number;
    return $new_invoice_sequencr;
}

function generatePOSSequenceInvoice($prefix)
{
    $prefix = 'POS';
    $preferences = UserPreferences::getPreferences();
    $hospitalId = $preferences['preference']['hospital_id'];

    $lastInvoice = PosInvocie::where('hospital_id', $hospitalId)
        ->whereNotNull('invoice_sequence')
        ->orderByDesc('id') // or orderBy('created_at', 'desc')
        ->first();

    $last_sequence = isset($lastInvoice->invoice_sequence) ? $lastInvoice->invoice_sequence : null;
    $sequence_number = 0;

    if (preg_match('/-(\d+)$/', $last_sequence, $matches)) {
        $sequence_number = (int) $matches[1];
    } else {
        $sequence_number = 0;
    }

    $sequence_number++; // Increment the sequence number
    $hospital_abbreivation = null;

    switch ($hospitalId) {
        case 1:
            $hospital_abbreivation = 'SIRM';
            break;
        case 2:
            $hospital_abbreivation = 'SCH';
            break;
        default:
            $hospital_abbreivation = 'SIRM';
            break;
    }

    $new_invoice_sequence = $hospital_abbreivation . '-' . $prefix . '-' . $sequence_number;
    return $new_invoice_sequence;
}

function generateSequence($prefix)
{
    $prefix = 'IN';
    $preferences = UserPreferences::getPreferences();
    $hospitalId = $preferences['preference']['hospital_id'];

    $lastInvoice = Invoice::where('hospital_id', $hospitalId)
        ->whereNotNull('invoice_sequence')
        ->orderByDesc('id') // or orderBy('created_at', 'desc')
        ->first();

    $last_sequence = isset($lastInvoice->invoice_sequence) ? $lastInvoice->invoice_sequence : null;
    $sequence_number = 0;

    if (preg_match('/-(\d+)$/', $last_sequence, $matches)) {
        $sequence_number = (int) $matches[1];
    } else {
        $sequence_number = 0;
    }

    $sequence_number++; // Increment the sequence number
    $hospital_abbreivation = null;

    switch ($hospitalId) {
        case 1:
            $hospital_abbreivation = 'SIRM';
            break;
        case 2:
            $hospital_abbreivation = 'SCH';
            break;
        default:
            $hospital_abbreivation = 'SIRM';
            break;
    }

    $new_invoice_sequencr = $hospital_abbreivation . '-' . $prefix . '-' . $sequence_number;
    return $new_invoice_sequencr;
}

function getOPDStatusLabel($statusId)
{
    switch ($statusId) {
        case 'pending':
            return 'btn btn-info';
            break;
        case 'completed':
            return 'btn btn-success';
            break;
        case 'cancelled':
            return 'btn btn-danger';
            break;
        case 'referred':
            return 'btn btn-primary';
            break;
    }
}


function redirectDashboardLinkByRole()
{
    $user = auth()->user();

    if (!is_null($user)) {
        $role_id = $user->role_id;

        switch ($role_id) {
            case 1:
            case 2:
            case 4:
                return redirect()->route('dashboard'); // opd dashboard
            case 3:
                return redirect()->route('doctor.dashboard'); // doctor dashboard
            case 5:
                return redirect()->route('finance.dashboard'); // finance dashboard
            case 6:
                return redirect()->route('pathology.dashboard'); // laboratory dashboard
            case 7:
                return redirect()->route('pharmacy.dashboard'); // pharmacy dashboard
            default:
                return redirect()->route('dashboard'); // default dashboard
        }
    } else {
        return redirect()->route('login'); // default login
    }
}


function getDashboardLinkByRole()
{

    $user = auth()->user();

    if (!is_null($user)) {
        $role_id = $user->role_id;

        switch ($role_id) {

            case 1:
                return route('dashboard'); //opd dashboard
                break;
            case 2:
                return route('dashboard'); //opd dashboard
                break;
            case 3:
                return route('doctor.dashboard'); // doctor dashboard
                break;
            case 4:
                return route('dashboard'); //opd dashboard
                break;
            case 5:
                return route('finance.dashboard'); // finance dashboard
                break;
            case 6:
                return route('pathology.dashboard'); // laboratory dashboard
                break;
            case 7:
                return route('pharmacy.dashboard'); // pharmacy dashboard
                break;
            default:
                return route('dashboard'); // default dashboard
        }

    } else {
        return route('login'); // default login
    }

}

function getDashboardLinkBasedOnRole()
{
    $user = auth()->user();
    if ($user) {
        $doctor = Doctor::where('user_id', $user->id)->first();
        if ($doctor) {
            return route('doctor.dashboard');
        } else {
            return route('dashboard');
        }
    } else {
        ErrorMessage('login');
    }
}

function getLabGroupTestStatus($statusId)
{
    switch ($statusId) {
        case 'pending':
            return 'btn btn-info';
            break;
        case 'collected':
            return 'btn btn-success';
            break;
        case 'in_process':
            return 'btn btn-primary';
            break;
        case 'completed':
            return 'btn btn-warning';
            break;
    }
}

function getLabGroupStatus($statusId)
{
    switch ($statusId) {
        case 'pending':
            return 'btn btn-info';
            break;
        case 'completed':
            return 'btn btn-success';
            break;
        case 'cancelled':
            return 'btn btn-danger';
            break;
    }
}

function geInvoicePDF($pdf, $returnPath = true)
{

    $dir = \App\Models\Billing::getBillInvoicesDir();

    if ($pdf == '' || !File::exists($dir . $pdf)) {
        $path = url("images/no-image.png");
        $rtn = false;
    } else {
        $path = url($dir . $pdf);
        $rtn = true;
    }
    return $returnPath ? $path : $rtn;
}

//slug generation code goes
function convertTitleToSlug($str)
{
    // Convert string to lowercase
    $str = strtolower($str);
    // Replace the spaces with hyphens
    $str = str_replace(' ', '-', $str);
    // Remove the special characters
    $str = preg_replace('/[^a-z0-9\-]/', '', $str);
    // Remove the consecutive hyphens
    $str = preg_replace('/-+/', '-', $str);
    // Trim hyphens from the beginning
    // and ending of String
    $str = trim($str, '-');
    return $str;
}

function getBasicDateTimeDiffForHumans($date)
{
    return Carbon::parse($date)->diffForHumans();
}

function getBasicDateTimeFormat($date, $format = 'd-m-Y g:i A')
{
    return date($format, strtotime($date));
}

function getActiveHospitalName($hospital_id)
{
    $hospital = Hospital::find($hospital_id);
    return $hospital->name . ' (' . $hospital->hospital_abbreviation . ')';
}

function returnMonth($billing_details = false)
{
    return Carbon\Carbon::parse($billing_details->bill_month)->format('M');
}

function getBasicDateFormat($date, $format = 'jS F Y')
{
    return date($format, strtotime($date));
}

function getDateInStandardFormat($date)
{
    $currentDate = $date->format('d-m-Y');
    return $currentDate;
}

function getShortDateTimeFormat($date, $format = 'j M y h:i A')
{
    return date($format, strtotime($date));
}

function getDoctorNameById($id)
{
    return optional(Doctor::find($id))->doctor_name ?? '';
}

function getDepartmentNameById($id)
{
    return optional(Department::find($id))->name ?? '';
}


function getMyStatusLabel($statusId = '')
{
    switch ($statusId) {
        case 0:
            return '<span class="mr-2 badge badge-danger font-weight-lighter">In-Active</span>';
            break;
        case 1:
            return '<span class="mr-2 badge badge-success font-weight-lighter">Active</span>';
            break;
    }
}

function getFinanceApprovalStatusLabel($statusId = '')
{
    switch ($statusId) {
        case 0:
            return '<span class="mr-2 badge badge-danger font-weight-lighter">Not Approved</span>';
            break;
        case 1:
            return '<span class="mr-2 badge badge-success font-weight-lighter">Approved</span>';
            break;
    }
}


function getOPDStatusValuesBasedOnStatus($statusId)
{
    switch ($statusId) {
        case 'pending':
            return '<span class="mr-2 badge badge-info font-weight-lighter">Pending</span>';
            break;
        case 'completed':
            return '<span class="mr-2 badge badge-success font-weight-lighter">Completed</span>';
            break;
        case 'cancelled':
            return '<span class="mr-2 badge badge-danger font-weight-lighter">Cancelled</span>';
            break;
        case 'referred':
            return '<span class="mr-2 badge badge-primary font-weight-lighter">Referred</span>';
            break;
    }
}

function getInhouseStatusLable($statusId = '')
{
    switch ($statusId) {
        case 0:
            return '<span class="mr-2 badge badge-danger font-weight-lighter">Not Available</span>';
            break;
        case 1:
            return '<span class="mr-2 badge badge-success font-weight-lighter">Available</span>';
            break;
    }
}

function checkDoctorSpecialistStatus($is_specialist = '')
{
    switch ($is_specialist) {
        case 0:
            return '<span class="mr-2 badge badge-info font-weight-lighter">Medical Officer</span>';
            break;
        case 1:
            return '<span class="mr-2 badge badge-success font-weight-lighter">Specialist</span>';
            break;
    }
}

function titleFilter($title)
{
    return str_replace('_', ' ', ucfirst($title));
}

function BackEndUrl()
{
    return env('APP_API_URL', 'http://localhost:4201');
}

function AvatarImagePath($image, $returnPath = true)
{
    $dir = \App\Models\User::AvatarImage();

    if ($image == '' || !File::exists($image)) {
        $path = url('src/media/avatars/300-1.jpg');
        $rtn = false;

    } else {

        $path = url($image);
        $rtn = true;

    }

    return $returnPath ? $path : $rtn;
}


function CustomerAvatarImagePath($image, $returnPath = true)
{
    $dir = \App\Models\Customer::AvatarImage();

    if ($image == '' || !File::exists($image)) {
        $path = url('src/media/avatars/300-1.jpg');
        $rtn = false;

    } else {

        $path = url($image);
        $rtn = true;

    }

    return $returnPath ? $path : $rtn;
}

function generate_mr_number($type, $doy, $id)
{

    // switch ($type) {

    //     case 'resident':
    //         $slug = 'RE-' . $doy . '-000' . $id;
    //         return $slug;

    //     case 'non_resident':
    //         $slug = 'NR-' . $doy . '-000' . $id;
    //         return $slug;

    //     case 'employee':
    //         $slug = 'EM-' . $doy . '-000' . $id;
    //         return $slug;

    //     case 'employee_resident':
    //         $slug = 'EMR-' . $doy . '-000' . $id;
    //         return $slug;

    //     case 'employee_family':
    //         $slug = 'EMF-' . $doy . '-000' . $id;
    //         return $slug;
    // }

    $prefixes = [
        'resident' => 'RE',
        'non_resident' => 'NR',
        'employee' => 'EM',
        'employee_resident' => 'EMR',
        'employee_family' => 'EMF',
    ];

    if (!isset($prefixes[$type])) {
        return null; // or throw exception / return default
    }

    return $prefixes[$type] . '-' . $doy . '-' . $id;

}

function generateRandomString($length = 10)
{
    return bin2hex(random_bytes($length));
}


function genSSH512($datetime)
{
    $salt = \Str::random(12);
    $value = base64_encode(hash('sha512', $datetime . $salt, true) . $salt);
    //only allowing alpha numberic through a generated string
    $result = preg_replace("/[^a-zA-Z0-9]+/", "", $value);
    return $result;
}

function checkPersonPermission($per, $perString = false)
{
    if (auth()->user()->role_id == 1) {
        return true;
    }

    $per = is_array($per) ? $per[0] . '-' . $per[1] . '-' . $per[2] : $per;
    if ($perString === false) {
        $perString = session()->get('rights');
    }
    $per = '|' . $per . '|';

    return Str::of($perString)->contains($per);
}


function checkPersonPermissionforValidation($per, $perString = false)
{
    $per = is_array($per)
        ? $per[0] . '-' . $per[1] . '-' . $per[2]
        : $per;

    if ($perString === false) {
        $perString = session()->get('rights');
    }

    $per = '|' . $per . '|';
    //d($perString);
    return Str::of($perString)->contains($per);
}

function getRootUsers()
{
    return array(1);
}

function getApplicationlanguages()
{
    $languages = ['English' => 'en', 'Arabic' => 'ar'];
    return $languages;
}

function mrNumberGenerator($id)
{

    $year = date("y");
    $number = "CSC-SIRM-" . $year . "-" . $id;
    return $number;
}



function ErrorMessage($type = 403, $rtnType = 'redirect')
{
    switch ($type) {
        case 403:
            $withMessage = [
                'Status' => 403,
                'hasPopup' => true,
                'messageTitle' => 'Permission denied',
                'messageData' => "You don't have permission to access that page",
            ];
            if ($rtnType == 'redirect') {
                // return redirect('/403')->with($withMessage);
                return view('errors.403');

            }
            break;
        case 404:
            $withMessage = [
                'Status' => 404,
                'hasPopup' => true,
                'messageTitle' => 'Page not found',
                'messageData' => 'Opps, Something went wrong',
            ];
            if ($rtnType == 'redirect') {
                return redirect('/404')->with($withMessage);
            }
            break;

        // case 401:
        //     $withMessage = [
        //         'Status' => 401,
        //         'hasPopup' => true,
        //         'messageTitle' => 'Permission Not Allowed',
        //         'messageData' => 'Opps, Something went wrong',
        //     ];
        //     if ($rtnType == 'redirect') {
        //         return view('errors.401');
        //     }
        //     break;

        case 'login':
            $withMessage = [
                'Status' => 404,
                'hasPopup' => true,
                'messageTitle' => 'Session Expired',
                'messageData' => 'Login again to proceed.',
            ];
            if ($rtnType == 'redirect') {
                return redirect('/login')->with($withMessage);
            }
            break;
    }

    return response()->json($withMessage);
}

function getExcelSheetTemplateUrl($key = false)
{

    $excel_sheets = array(
        "investigations" => url('opd/Investigations.xlsx'), //
        "complaints" => url('opd/complaints.xlsx'), //
        "gpe" => url('opd/gpe.xlsx'), //
        "diagnosis" => url('opd/diagnosis.xlsx'), //
        "spe" => url('opd/spe.xlsx'), //
        "medications" => url('opd/medications.xlsx'), //
    );

    return $excel_sheets[$key];
}

function getModelImportData($model = false)
{

    $models = array();
    $models['Complaint'] = array(
        "name" => "Name",
        "description" => "description",
        "parent_id" => 0,
        "created_by" => "1",
    );

    $models['Diagnosis'] = array(
        "code" => "123",
        "name" => "Name",
        "created_by" => 1,
    );

    $models['GeneralPhysicalExamination'] = array(
        "name" => "Name",
        "description" => "description",
        "parent_id" => 0,
        "created_by" => "1",
    );

    $models['SystematicPhysicalExamination'] = array(
        "name" => "Name",
        "description" => "description",
        "parent_id" => 0,
        "created_by" => "1",
    );

    $models['Medicines'] = array(
        "name" => "Name",
        "medicine_category_id" => "1",
        "is_in_house" => "1",
        "created_by" => "1",
        'short_name' => "test"
    );

    $models['Investigations'] = array(
        "type_id" => 0,
        "name" => "Name",
        "basic_info" => "Basic info",
        "description" => "description",
        "working" => "working",
        "faqs" => "faqs",
        "results" => "results",
        "why_get_tested" => "why_get_tested",
        "created_by" => "1",
    );

    if ($model) {
        return $models[$model];
    }
}

function checkIfUserIsDoctor($user_id)
{
}

function checkIfUserIsAdmin()
{

    if (auth()->user()->role_id == 1) {
        return true;
    } else {
        return false;
    }

}

function getHospitals()
{

    $hospitals = [

        ['id' => 1, 'name' => 'Pakistan Institute of Medical Sciences (PIMS)'],
        ['id' => 2, 'name' => 'Federal Government Services Hospital'],
        ['id' => 3, 'name' => 'Capital Hospital (CDA Hospital)'],
        ['id' => 4, 'name' => 'National Institute of Health'],
        ['id' => 5, 'name' => 'Nuclear Oncology & Radiotherapy Institute (NORI)'],
        ['id' => 6, 'name' => 'NESCOM Hospital'],
        ['id' => 7, 'name' => 'KRL Hospital'],
        ['id' => 8, 'name' => 'Shifa International Hospital'],
        ['id' => 9, 'name' => 'Ali Medical Centre'],
        ['id' => 10, 'name' => 'Maroof International Hospital'],
        ['id' => 11, 'name' => 'Kulsum International Hospital'],
        ['id' => 12, 'name' => 'Integrated Health Services'],
        ['id' => 13, 'name' => 'HS Childrens Medical Centre'],
        ['id' => 14, 'name' => 'Medicsi'],
        ['id' => 15, 'name' => 'Islamabad International Hospital & Research Center'],
        ['id' => 16, 'name' => 'Amanat Eye Hospital'],
        ['id' => 17, 'name' => 'Maxhealth Hospital'],
        ['id' => 18, 'name' => 'Family Health Hospital'],
        ['id' => 19, 'name' => 'PAF Hospital'],
        ['id' => 20, 'name' => 'Medcity International Hospital'],
        ['id' => 21, 'name' => 'Armed Forces Institute of Cardiology (AFIC)'],
        ['id' => 22, 'name' => 'Benazir Bhutto Hospital, Rawalpindi'],
        ['id' => 23, 'name' => 'Holy Family Hospital, Rawalpindi'],
        ['id' => 24, 'name' => 'Rawalpindi Institute of Cardiology (RIC)'],
        ['id' => 25, 'name' => 'Quaid-e-Azam International Hospital (QIH)'],
        ['id' => 26, 'name' => 'Combined Military Hospital (CMH) Rawalpindi'],
        ['id' => 27, 'name' => 'Civil Hospital, Rawalpindi'],
        ['id' => 28, 'name' => 'Al Shifa Eye Trust Hospital, Rawalpindi'],
        ['id' => 29, 'name' => 'Fauji Foundation Hospital, Rawalpindi'],
        ['id' => 30, 'name' => 'Bilal Hospital, Rawalpindi'],
        ['id' => 31, 'name' => 'Hearts International Hospital, Rawalpindi'],
        ['id' => 32, 'name' => 'Jinnah Memorial Hospital, Rawalpindi'],
        ['id' => 33, 'name' => 'Aga Khan University Hospital — Zaib Medical Centre, Rawalpindi'],
        ['id' => 34, 'name' => 'Ahmad Medical Complex, Rawalpindi'],
        ['id' => 35, 'name' => 'Al Qaim Medical & Surgical Complex, Rawalpindi'],
        ['id' => 36, 'name' => 'Al-Shifa Trust Eye Hospital, Rawalpindi'],
        ['id' => 37, 'name' => 'Amer Eye Hospital, Rawalpindi'],
        ['id' => 38, 'name' => 'Anwar Hospital, Rawalpindi'],
        ['id' => 39, 'name' => 'Ayesha Hospital, Rawalpindi'],
        ['id' => 40, 'name' => 'Chinese Hospital, Rawalpindi'],
        ['id' => 41, 'name' => 'Al-Syed Hospital, Taxila'],
        ['id' => 42, 'name' => 'Bahria International Cardiac Surgery, Rawalpindi'],
        ['id' => 43, 'name' => 'Christian Hospital, Taxila'],
        ['id' => 44, 'name' => 'Farooq Hospital, Rawalpindi'],
        ['id' => 45, 'name' => 'Friends Welfare Trust Hospital, Rawalpindi'],
        ['id' => 46, 'name' => 'Hussain Lakhani International Hospital, Rawalpindi'],
        ['id' => 47, 'name' => 'Mega Medical Complex, Rawalpindi'],
        ['id' => 48, 'name' => 'Minsa Medical Centre, Rawalpindi'],
        ['id' => 49, 'name' => 'Maryam Memorial Hospital, Rawalpindi'],
        ['id' => 50, 'name' => 'Rawalpindi Leprosy Hospital'],
        ['id' => 51, 'name' => 'Quaid-e-Azam International Hospital (Islamabad branch)'],
        ['id' => 52, 'name' => 'Life Care Hospital, Islamabad'],
        ['id' => 53, 'name' => 'Dr Akbar Niazi Teaching Hospital (ANTH), Islamabad'],
        ['id' => 54, 'name' => 'Dr. Sadaf’s Specialized Hospital, Islamabad'],
        ['id' => 55, 'name' => 'Global Health Services (QIH) Islamabad'],
        ['id' => 56, 'name' => 'Islamabad Intl Hospital & Research Center'],
        ['id' => 57, 'name' => 'Isra Islamic Foundation Hospital, Islamabad'],
        ['id' => 58, 'name' => 'Riphah International Hospital, Islamabad'],
        ['id' => 59, 'name' => 'Rawal Foundation Hospital, Islamabad'],
        ['id' => 60, 'name' => 'Zobia Hospital, Islamabad'],
        ['id' => 61, 'name' => 'PNS Hafeez Hospital, Islamabad'],
        ['id' => 62, 'name' => 'Holy Family Hospital, Islamabad'],
        ['id' => 63, 'name' => 'PAF Hospital, Islamabad'],
        ['id' => 64, 'name' => 'Life Care Hospital G-10, Islamabad'],
        ['id' => 65, 'name' => 'Kulsum International Hospital, Islamabad'],
        ['id' => 66, 'name' => 'Dr. Shifa International Hospital, Islamabad'],
        ['id' => 67, 'name' => 'Medikay Cardiac Center, Islamabad'],
        ['id' => 68, 'name' => 'Al Khidmat Raazi Hospital, Islamabad'],
        ['id' => 69, 'name' => 'Islamic International Medical College Trust Hospital, Rawalpindi'],
        ['id' => 70, 'name' => 'Al Shahbaz Medical Complex, Kahuta'],
        ['id' => 71, 'name' => 'Tehsil Headquarter Hospital, Kotli Sattian'],
        ['id' => 72, 'name' => 'Tehsil Headquarter Hospital, Murree'],
        ['id' => 73, 'name' => 'Wah General Hospital, Taxila'],
        ['id' => 74, 'name' => 'Basharat Hospital, Rawalpindi'],
        ['id' => 75, 'name' => 'Holy Family Hospital, Rawalpindi (Satellite Town)'],
        ['id' => 76, 'name' => 'Tehsil Headquarter Hospital, Taxila (Rawalpindi District)']


    ];
    return $hospitals;

}

function redirectToDoctorPanel()
{
    $user = auth()->user();

    if ($user) {

        $doctor = Doctor::where('user_id', $user->id)->first();
        if ($doctor) {
            return redirect()->intended(route('doctor.dashboard'));
        } else {
            return redirect()->intended(route('dashboard'));
        }
    } else {
        ErrorMessage('login');
    }
}

function giveRedirectValue()
{
    $user = auth()->user();
    if ($user) {
        $doctor = Doctor::where('user_id', $user->id)->first();
        if ($doctor) {
            $route = route('doctor.dashboard');
            return $route;
        } else {
            $route = route('dashboard');
            return $route;
        }
    } else {
        ErrorMessage('login');
    }
}

function getDefaultOPDDoctorLayout()
{
    $default_opd_layout = 'modern';
    $doctorVal = checkDoctorPanelVal();
    if ($doctorVal) {
        $user = auth()->user();
        if ($user) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $opd_layout = $doctor->opd_layout;
            $default_opd_layout = $opd_layout;
            return $default_opd_layout;
        }
    } else {
        $default_opd_layout = 'modern';
        return $default_opd_layout;
    }
}

function checkDoctorPanelVal()
{
    $user = auth()->user();
    if ($user) {
        $doctor = Doctor::where('user_id', $user->id)->first();
        if ($doctor) {
            return true;
        } else {
            return false;
        }
    } else {
        ErrorMessage('login');
    }
}


function getDoctorId()
{
    $user = auth()->user();
    if ($user) {
        $doctor = Doctor::where('user_id', $user->id)->first();
        if ($doctor) {
            return $doctor->id;
        }
    } else {
        ErrorMessage('login');
    }
}


function getHospitalNameById($id)
{
    $hospitals = [

        ['id' => 1, 'name' => 'Pakistan Institute of Medical Sciences (PIMS)'],
        ['id' => 2, 'name' => 'Federal Government Services Hospital'],
        ['id' => 3, 'name' => 'Capital Hospital (CDA Hospital)'],
        ['id' => 4, 'name' => 'National Institute of Health'],
        ['id' => 5, 'name' => 'Nuclear Oncology & Radiotherapy Institute (NORI)'],
        ['id' => 6, 'name' => 'Nescom Hospital'],
        ['id' => 7, 'name' => 'KRL Hospital'],
        ['id' => 8, 'name' => 'Shifa International Hospital'],
        ['id' => 9, 'name' => 'Ali Medical Centre'],
        ['id' => 10, 'name' => 'Maroof International Hospital'],
        ['id' => 11, 'name' => 'Kulsum International Hospital'],
        ['id' => 12, 'name' => 'Integrated Health Services'],
        ['id' => 13, 'name' => 'HS Childrens Medical Centre'],
        ['id' => 14, 'name' => 'Medicsi'],
        ['id' => 15, 'name' => 'Islamabad International Hospital & Research Center'],
        ['id' => 16, 'name' => 'Amanat Eye Hospital'],
        ['id' => 17, 'name' => 'Maxhealth Hospital'],
        ['id' => 18, 'name' => 'Family Health Hospital'],
        ['id' => 19, 'name' => 'PAF hospital'],
        ['id' => 20, 'name' => 'Medcity International Hospital'],

    ];

    $value_to_check = $id;
    $value_exists = false;
    $hospital = null;

    foreach ($hospitals as $hos) {
        if ($hos['id'] == $value_to_check) {
            $value_exists = true;
            $hospital = $hos;
            return $hospital['name'];
            break;
        }
    }

}
