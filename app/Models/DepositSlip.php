<?php

namespace App\Models;

use Carbon\Carbon;
use Response;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepositSlip extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'deposit_slips';

    protected $fillable = [
        'user_id',
        'hospital_id',
        'date_issued',
        'deposit_slip_number',
        'counter_number',
        'amount_in_figures',
        'amount_in_words',
        'payment_purpose',
        'deposit_slip_file_name',
        'deposit_slip_file_fullpath',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    // Static Methods
    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getDepositsCount()
    {
        return self::count();
    }

    public static function getAll()
    {
        $request = request();

        $search['q'] = $request->has('q') ? $request->get('q') : false;
        $search['date_from'] = $request->has('date_from') ? $request->get('date_from') : false;
        $search['date_to'] = $request->has('date_to') ? $request->get('date_to') : false;
        $search['hospital'] = $request->has('hospital') ? $request->get('hospital') : false;


        $data = self::leftJoin('users as u', 'u.id', '=', 'deposit_slips.user_id')
            ->leftJoin('hospitals as h', 'h.id', '=', 'deposit_slips.hospital_id')
            ->select([
                'deposit_slips.*',
                'u.name as user_name',
                'h.name as hospital_name'
            ]);

        if ($search['q']) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('u.name', 'iLIKE', "%{$search['q']}%")
                    ->orWhere('deposit_slips.deposit_slip_number', 'iLIKE', "%{$search['q']}%");
            });
        }

        if ($search['date_from']) {
            $data = $data->whereDate('deposit_slips.date_issued', '>=', $search['date_from']);
        }

        if ($search['date_to']) {
            $data = $data->whereDate('deposit_slips.date_issued', '<=', $search['date_to']);
        }

        if ($search['hospital']) {
            $data = $data->where('deposit_slips.hospital_id', $search['hospital']);
        }

        $rtn['search'] = $search;
        $rtn['data'] = $data->orderBy('deposit_slips.created_at', 'desc')->paginate(10);

        return $rtn;
    }


    function displayAmountInWords($number)
    {

        $no = (int) floor($number);
        $point = (int) round(($number - $no) * 100);
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'forty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lac', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;


            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);


        if ($point > 20) {
            $points = ($point) ?
                "" . $words[floor($point / 10) * 10] . " " .
                $words[$point = $point % 10] : '';
        } else {
            $points = $words[$point];
        }
        if ($points != '') {
            return $result . "Rupees  " . $points . " Paise Only";
        } else {
            return $result . "Rupees Only";
        }

    }

    public function addForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'user_id' => ['required'],
            'hospital_id' => ['required'],
            'counter_number' => ['required', 'string', 'max_digits:5'],
            'amount_in_figures' => ['required', 'numeric', 'max_digits:9'],
            'payment_purpose' => ['required', 'string'],
        ], [
            'user_id.required' => 'Name of the user is required',
            'counter_number.required' => 'Counter number is required',
            'amount_in_figures.required' => 'Amount in figures is required',
            'payment_purpose.required' => 'Payment Purpose is required'
        ]);

        $amount_in_words = $this->displayAmountInWords($request->amount_in_figures);

        $obj = new DepositSlip;
        $obj->user_id = $request->user_id;
        $obj->hospital_id = $request->hospital_id;
        $obj->date_issued = Carbon::now();
        $obj->deposit_slip_number = $this->generateSlipNumber();
        $obj->counter_number = $request->counter_number;
        $obj->amount_in_figures = $request->amount_in_figures;
        $obj->amount_in_words = $amount_in_words;
        $obj->payment_purpose = $request->payment_purpose;
        $obj->created_by = auth()->user()->id;
        $obj->save();

        $this->generatePDF($obj);

        session()->flash('success', 'Deposit slip generated successfully');
        return Redirect::route('deposit_slips.index');
    }

    public static function getDepositSlipsDir()
    {
        return 'assets/deposit-slips/';
    }

    public function downloadPDF($id)
    {

        $obj = DepositSlip::find($id);
        $FileName = $obj->deposit_slip_file_name;
        $file = $obj->deposit_slip_file_fullpath;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, $FileName, $headers);

    }

    public function generatePDF($obj)
    {

        $hospital = Hospital::find($obj->hospital_id);
        $user_data = User::find($obj->user_id);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('documents.deposit_slips.deposit_slip', compact('obj', 'hospital', 'user_data'))
            ->setPaper('A4', 'landscape');

        $dir = self::getDepositSlipsDir();

        $extension = 'pdf';
        $FileName = strtolower(time() . '_' . rand(1000, 9999) . '.' . $extension);
        $path = public_path() . '/' . $dir;
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        $pdf->save($path . $FileName);
        $file = $path . $FileName;
        $obj->deposit_slip_file_name = $FileName;
        $obj->deposit_slip_file_fullpath = $file;
        $obj->update();

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, $FileName, $headers);
    }

    private function generateSlipNumber()
    {
        $lastSlip = self::orderBy('id', 'desc')->first();
        $nextId = ($lastSlip ? $lastSlip->id : 0) + 1000;
        return $nextId;
    }

    public function updateForm($request = false)
    {
        if ($request === false) {
            $request = request();
        }

        $request->validate([
            'user_id' => ['required'],
            'hospital_id' => ['required'],
            'counter_number' => ['required', 'string', 'max_digits:5'],
            'amount_in_figures' => ['required', 'numeric', 'max_digits:9'],
            'amount_in_words' => ['required', 'string'],
            'payment_purpose' => ['required', 'string'],
        ], [
            'user_id.required' => 'Name of the user is required',
            'counter_number.required' => 'Counter number is required',
            'amount_in_figures.required' => 'Amount in figures is required',
            'amount_in_words.required' => 'Amount in words is required',
            'payment_purpose.required' => 'Payment Purpose is required'
        ]);

        $amount_in_words = $this->displayAmountInWords($request->amount_in_figures);

        $obj = DepositSlip::find($request->id);
        $obj->user_id = $request->user_id;
        $obj->hospital_id = $request->hospital_id;
        $obj->counter_number = $request->counter_number;
        $obj->amount_in_figures = $request->amount_in_figures;
        $obj->amount_in_words = $amount_in_words;
        $obj->payment_purpose = $request->payment_purpose;
        $obj->date_issued = Carbon::now();
        $obj->updated_by = auth()->user()->id;
        $obj->update();

        $this->generatePDF($obj);

        session()->flash('success', 'Deposit slip updated successfully');
        return redirect()->route('deposit_slips.index');
    }

    // Add this to your DepositSlip model
    public function getFormattedSlipNumberAttribute()
    {
        return 'SLIP-' . str_pad($this->deposit_slip_number, 6, '0', STR_PAD_LEFT);
    }

    public function deleteObj()
    {
        $this->deleted_by = auth()->user()->id;
        $this->save();
        $this->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deposit slip has been deleted successfully',
        ]);
    }
}
