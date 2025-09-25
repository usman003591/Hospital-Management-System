<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab Report</title>

    <style>
        *{
            padding: 0px;
            margin: 0px;

        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            padding: 4px;
        }

        .logo {
            width: 80px;
        }

        .title-main {
            font-size: 22px;
            font-weight: bold;

        }

        .title-sub {
            /* background: #2dce27; */
            background: #01a54e;
            color: white;
            padding: 7px;;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            width: 410px;
            text-align: center;

        }

        .title-sub_two {
            background: #8ea8a3;
            color: #fff;
            padding: 3px 6px;
            font-size: 12px;
            width: 412px;
            line-height: 1.2;
        }
        .urdu {
            font-size: 11px;
        }

        .patient-info {
            text-align: left !important;
            font-size: 12px;
            line-height: 1.8;
        }

        .divider {
            border-bottom: 1px solid #000;
            /* margin: 5px 0; */
        }

        .report-info {
            width: 100%;
            font-size: 12px;
            /* font-weight: bold; */
            /* margin-top: 4px; */
        }

        .report-info td {
            padding: 3px 0;
        }
        .results-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        }
        .results-table th,
        .results-table td {
            border-bottom: 1px solid #e7d3d3;
            /* border-bottom: 1px solid black; */
            padding: 4px;
            text-align: center;
        }
        .results-table th:first-child,
        .results-table td:first-child {
            text-align: left; /* test names on left */
        }

        .test-header {
            /* margin-top: 10px; */
            border-bottom: 1px solid #000;
            font-weight: bold;
            font-size: 12px;
        }
        .test-header_two {

            border-bottom: 1px solid #000;
            font-size: 12px;
            background-color: grey;
            margin-top: 2px;
        }

        .test-row {
        border-bottom: 1px solid #000;
        }
        .test-row td {
            padding: 4px;
            font-size: 11px;
        }
        .val {
            padding-left: 40px; /* current result */
        }
        .prev {
            padding-left: 10px;
        text-align: center;
        word-spacing: 20px;
        white-space: nowrap;
        }
        .ref {
            padding-left: 20px; /* reference range */
        }

        .section-title {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        .comments {
            margin-top: 12px;
            font-size: 11px;
            line-height: 1.5;
        }


        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            width: 100%;
            font-size: 12px;
            /* border: 1px solid #000; */
            padding-top: 5px;

        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            vertical-align: middle;
            padding: 2px 20px;
        }

        .footer-left {
            text-align: left;
            font-size: 10px;

        }

        .footer-right {
            text-align: right;
            white-space: nowrap;
            /* border: 2px solid black; */
            padding-bottom: -130px;

        }

        .footer-right img {
            /* vertical-align: middle; */
            vertical-align: bottom;
            margin-right: 5px;
        }

        .arrow-down {
        color: red;
        font-weight: bold;
        font-size: 14px;
        }

        .value-bold {
            font-weight: bold;
        }


            .urdu-text {
        font-family: 'urdu', 'DejaVu Sans', sans-serif;
        direction: rtl;
        text-align: right;
        font-size: 14px; /* optional */
        line-height: 1.6; /* optional */
    }


    </style>
</head>
<body>

        @php
            // $logo = base64_encode(file_get_contents(public_path('assets/media/logos/logo_without_background_1.png')));
            // $qrCode = base64_encode(file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=DummyQR'));
            $redArrowDown = base64_encode(file_get_contents(public_path('red_arrow_down.png')));
            $redArrowUp = base64_encode(file_get_contents(public_path('red_arrow_Up.png')));
        @endphp
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <!-- Logo -->
            <td class="logo">
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}" alt="Hospital Logo" width="80">
            </td>

            <!-- Title -->
            <td>
                <div class="title-main">@isset($hospital->name) {{$hospital->name}} @endisset</div>
                {{-- <div class="urdu-text">رپورٹ برائے مریض</div> --}}
                <div class="title-sub">IMAGING & LAB SERVICES</div><br>
                <div class="title-sub_two"></div>
                <div style="font-size: 10px; margin-top: 40px;">
                 @isset($hospital->address) {{$hospital->address}} @endisset
                </div>
            </td>

            <!-- Patient Info + QR -->
            <td class="patient-info" style="padding-top : 10px">
                <div>@isset($patient->name_of_patient) {{ \Illuminate\Support\Str::limit($patient->name_of_patient, 15, '..') }}  @endisset </div>
                <div>MR No: @isset($patient->patient_mr_number) {{$patient->patient_mr_number}} @endisset </div>
                <div>Gender: @isset($patient->gender) {{ucfirst($patient->gender)}} @endisset </div>
                <div>Age: @isset($patient->age) {{$patient->age}} @endisset Years</div>
                {{-- <div>CNIC: @isset($patient->cnic) {{$patient->cnic}} @endisset </div> --}}
                <div>Ref.By:<strong> @isset($doctor->doctor_name) {{ \Illuminate\Support\Str::limit($doctor->doctor_name, 15, '..') }}  @else self @endisset </strong></div>
            </td>
            <div style="margin-top:16px;">
                <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" width="60">
            </div>
        </tr>
    </table>

    <div class="divider"></div>
    <!-- Report Info -->
    <table class="report-info">
        <tr>
            @php
            $date = new DateTime($patient->created_at, new DateTimeZone('Asia/Karachi'));
            $yourDate = $date->format('Y-m-d H:i:s');
            $patient_visit_date =  \Carbon\Carbon::parse($yourDate)->format('d F, Y \a\t h:i A');
            @endphp
            <td>Visit Date: @isset($patient_visit_date) {{ $patient_visit_date }} @endisset</td>
            <td align="center" style="font-weight: bold;">Final Report </td>
            @php
            $date = new DateTime($obj->report_date, new DateTimeZone('Asia/Karachi'));
            $yourDate = $date->format('Y-m-d H:i:s');
            $report_date =  \Carbon\Carbon::parse($yourDate)->format('d F, Y \a\t h:i A');
            @endphp
            <td align="right">Report Date: @isset($report_date) {{ $report_date }} @endisset</td>
        </tr>
    </table>
    <div class="divider"></div>

    <table class="test-header" width="100%">
        <tr>
            <td width="25%">Test Name</td>
            <td width="20%">&nbsp;&nbsp;Results</td>
            <td width="40%">Last Results</td>
            <td width="20%">Reference Ranges</td>
        </tr>
    </table>

       <div class="section-title" style="font-size: 16px;">@isset($investigation)
                     {{$investigation->name}}
                    @endisset</div>
    <!-- Test Table Header -->
   <table class="results-table">
    <thead>
        <tr style="background: #ccc; font-weight: bold;">
            <th></th>
            @for($i = 0; $i < 4; $i++)
                @if(isset($resultsData[$i]))
                    <th>{{ \Carbon\Carbon::parse($resultsData[$i]->report_date)->format('d M Y') }}</th>
                @endif
            @endfor
            {{-- <th>8-Sep-25</th>
            <th>3-Jan-25</th>
            <th>24-Feb-25</th>
            <th>11-Aug-25</th> --}}
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($pivotedResults as $row)
            <tr>
                <td>{{ $row['name'] }}</td>
                @foreach($resultsData as $index => $test)
                    @php
                        $colKey = \Carbon\Carbon::parse($test->report_date)->format('d M Y') . " (#" . ($index+1) . ")";
                    @endphp
                    <td>{{ $row[$colKey] }}</td>
                @endforeach
                <td class="text-end">
                    {{ $row['reference_value'] ?? '-' }}
                    @if(!empty($row['unit'])) {{ $row['unit'] }} @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <!-- Comments -->
    <div class="comments">
        <strong>Comments:</strong><br>
        {{-- Peripheral smear reveals Anisocytosis. Normocytic, normochromic Anaemia. Platelets are adequate on smear. Clinical correlation is suggested. <br> --}}
        <em style="font-weight : bold">Disclaimer:</em> Every diagnostic test has scientific acceptable technology or technique based limitations of uncertainty of measurement, false positive or false negative and so do not fall under the domain of negligence. In case of any such scenario, we offer free repeat of test within 24-48 hours.
    </div>

    <div class="footer">
    <table>
        <tr>
            <td class="footer-left">

                @php
                $date = new DateTime('now', new DateTimeZone('Asia/Karachi'));
                $yourDate = $date->format('Y-m-d H:i:s');
                $print_datetime =  \Carbon\Carbon::parse($yourDate)->format('d F, Y \a\t h:i A');
                @endphp
                Printed by: HIMS {{ $print_datetime }}
            </td>
            <td class="footer-right">
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}" alt="IDC Logo" width="40">
                <strong>System Verified Report</strong>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
