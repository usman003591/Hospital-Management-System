<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPD Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A6;
            margin-top: 10mm 10mm;
        }

        .receipt {
            width: 80mm;
            padding: 10px;
            border: 1px solid rgb(145, 143, 143);
            margin: 10px auto;
            text-align: center;
        }

        .receipt_no {
            font-size: 11px;
            width: 100%;
        }

        .qr-code {
            margin-bottom: 10px;
        }

        .receipt-header {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .details {
            font-size: 11px;
            margin-bottom: 10px;
            text-align: left;
        }

        .details th,
        td {
            text-align: left;
            padding: 3px;
        }

        .footer {
            font-size: 10px;
            border-top: 1px dotted #000;
            padding-top: 5px;
            margin-top: 10px;
            font-style: italic;
        }

        .header {
            font-size: 10px;
            border-top: 1px dotted #000;
            padding-top: 5px;
            margin-top: 10px;
        }

        .hms-logo {
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }
    </style>

</head>

<body>
    <div class="receipt">
        <table class="receipt_no">
            <tr>
                <td style="text-align: left; width: 50%;">Token: @isset($clinical_diagnosis_data->count)
                    {{$clinical_diagnosis_data->count}} @endisset</td>
                <td style="text-align: right; width: 50%;">Counter: @isset($clinical_diagnosis_data->counter_name)
                    {{$clinical_diagnosis_data->counter_name}} @endisset</td>
            </tr>
        </table>
        <header class="header">
            <img class="hms-logo"
                src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}"
                alt="Logo">
            <div class="title-section" style="margin-top: 15px">
                <h2>{{$hospital->name}} ({{$hospital->hospital_abbreviation}})</h2>
                <br>
                <h4><strong>Health Directorate</strong></h4>
            </div>
        </header>

        <br>
        <div class="qr-code">
            <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" width="100">
            <br>
            <h5 style="font-size : 10px; margin: 5px !important">@isset($clinical_diagnosis_data->id)
                {{$clinical_diagnosis_data->id}} @endisset </h5>
        </div>
        {{-- <div class="receipt-header">OPD Receipt</div> --}}
        <table class="details">
            {{-- <tr>
                <th>OPD ID: </th>
                <td> @isset($clinical_diagnosis_data->id) {{$clinical_diagnosis_data->id}} @endisset </td>
            </tr> --}}
            <tr>
                <th>MR No.:</th>
                <td>@isset($patient_data->patient_mr_number) {{ $patient_data->patient_mr_number}} @endisset </td>
            </tr>
            <tr>
                <th>Patient Name: </th>
                <td>
                    @isset($patient_data->name_of_patient) {{ $patient_data->name_of_patient}} @endisset
                </td>
            </tr>
            <tr>
                <th>Department Name: </th>
                <td>@isset($department_data->name) {{ $department_data->name}} @endisset </td>
            </tr>
            <tr>
                <th>Doctor Name: </th>
                <td>
                    @isset($doctor_data->doctor_name) {{ $doctor_data->doctor_name}} @endisset
                </td>
            </tr>
            <tr>
                <th>Date: </th>
                <td>@isset($clinical_diagnosis_data->created_at)
                    {{getBasicDateFormat($clinical_diagnosis_data->created_at, "d/m/Y H:i")}} @endisset </td>
            </tr>
        </table>

        <div class="footer">
            {{-- Thank you for visiting! --}}
            <p>
                This is system generated slip, no signature or stamp required
            </p>
            {{-- <br>
            Doesn't require a signature and stamp --}}
        </div>
    </div>
</body>

</html>
