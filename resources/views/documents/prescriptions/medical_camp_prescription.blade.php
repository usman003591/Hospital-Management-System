<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            padding: 0;
            margin: 0;
            min-height: 100vh;
        }

        @page {
            size: A4;
            margin: 10mm 10mm;
            padding: 0;
        }

        .prescription-container {
            width: 100%;
            max-width: 200mm;
            margin: 0 auto;
            background-color: #fff;
            padding: 15px;
            min-height: 100vh;
        }

        .header {
            margin-bottom: 15px;
        }

        .tables {
            font-size: 14px;
        }

        .hms-logo {
            height: 70px;
            width: 70px;
            margin-bottom: 30px;
        }

        .csc-logo {
            height: 70px;
            width: 75px;
            margin-bottom: 25px;
        }

        .title-section {
            width: 60%;
            text-align: center;
        }

        .title-section h2 {
            font-size: 25px;
            margin-bottom: 5px;
        }

        .title-section h5 {
            font-size: 16px;
            margin-top: 5px;
            text-decoration: underline;
        }

        .details {
            margin-bottom: 10px;
        }

        .attributes-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .attributes-table tr {
            padding-bottom: 15px;
        }

        .attributes-table td {
            padding: 8px 5px 3px 5px;
            vertical-align: top;
            line-height: 18px;
            border-bottom: 1px solid dimgray;
        }

        .attributes-table th {
            padding: 8px 5px 3px 5px;
            vertical-align: top;
            line-height: 18px;
            text-align: left;
            width: 15%;
            white-space: nowrap;
        }

        .value-left {
            width: 30%;
        }

        .value-right {
            width: 23%;
        }

        .attributes-table .label-right {
            padding-left: 16px;
        }

        .text-section {
            border: none;
            width: 100%;
            min-height: 80px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-top: 20px;
        }

        .form-group h4 {
            font-size: 14px;
            margin: 0 0 8px 0;
        }

        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .footer {
            margin-top: 120px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
        }

        .next-visit {
            font-size: 14px;
            font-weight: bold;
        }

        .next-visit-field {
            width: 120px;
            margin-left: 5px;
        }

        .disclaimer {
            font-size: 12px;
            font-weight: bold;
            text-align: right;
            margin-top: 120px;
        }
    </style>
</head>
<body>
    <div class="prescription-container">
        <header class="header">
            <table style="width: 100%; table-layout: fixed; height: 10%;">
                <tr>
                    <td style="width: 20%; text-align: left;">
                        <img class="hms-logo"
                            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo.png')))}}"
                            alt="Logo">
                    </td>
                    <td class="title-section">
                        <div style="margin-top: 20px;">
                            <h2><u>{{$hospital->name}} ({{$hospital->hospital_abbreviation}})  </u></h2>
                            <h5><u>Capital Smart City Islamabad</u></h5>
                            {{-- <h5><strong>Health Directorate</strong></h5> --}}
                        </div>
                    </td>
                    <td style="width: 20%; text-align: right;">
                        <img class="csc-logo"
                            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('samrtcitylogo.png')))}}"
                            alt="Smart City Logo">
                    </td>
                </tr>
            </table>
        </header>

        <div class="tables">
        <section class="details">

            @isset($prescription_data->is_duplicate)
            @if($prescription_data->is_duplicate)
            <small style="color:red; margin : 6px">Duplicate</small>
            @endif
            @endisset

            <table class="attributes-table">
                <tbody>
                    <tr>
                        <th class="label-left">Counter Number:</th>
                        <td class="value-left" colspan="3">

                        </td>
                        <th class="label-right">Token Number:</th>
                        <td class="value-right">
                            @isset($prescription_data)
                            {{ $prescription_data->token_number }}
                            @endisset
                        </td>
                    </tr>
                    <tr>
                        <th class="label-left">Consultant:</th>
                        <td class="value-left" colspan="3">

                        </td>
                        <th class="label-right">Department:</th>
                        <td class="value-right">OPD</td>
                    </tr>

                    <tr>
                        <th class="label-left">Patient Name:</th>
                        <td class="value-left" colspan="3">@isset($patient_data)
                            {{ucfirst($patient_data->name_of_patient)}}
                            @endisset</td>
                        <th class="label-right">Category:</th>
                        <td class="value-right">@isset($patient_data)
                            {{titleFilter($patient_data->patient_category)}}
                            @endisset</td>

                    </tr>
                    <tr>
                        <th class="label-left">Gender:</th>
                        <td class="value-left">@isset($patient_data)
                            {{ucfirst($patient_data->gender)}}
                            @endisset</td>
                        <th style="width: 8%; padding-left: 18px;">Age:</th>
                        <td style="width: 15%">@isset($patient_data)
                            {{$patient_data->age}}
                            @endisset years</td>
                        <th class="label-right">Date:</th>
                        <td class="value-right">{{ getBasicDateFormat($prescription_data->created_at, 'd-m-Y H:i') ?? '' }}</td>
                    </tr>
                    <tr>
                        <th class="label-left">CNIC No:</th>
                        <td class="value-left" colspan="3">@isset($patient_data)
                            {{$patient_data->cnic_number}}
                            @endisset</td>
                        <th class="label-right">MR No:</th>
                        <td class="value-right">@isset($patient_data)
                            {{$patient_data->patient_mr_number}}
                            @endisset</td>
                    </tr>
                </tbody>
            </table>
        </section>

            <div class="form-group">
                <h4><u>Brief History</u></h4>
                <div class="text-section">
                    {{ $briefHistory ?? '' }}
                </div>
            </div>
            <div class="form-group">
                <h4><u>Examination</u></h4>
                <div class="text-section">
                    {{ $examination ?? '' }}
                </div>
            </div>
            <div class="form-group">
                <h4><u>Diagnosis</u></h4>
                <div class="text-section">
                    {{ $diagnosis ?? '' }}
                </div>
            </div>
            <div class="form-group">
                <h4><u>Treatment Advised</u></h4>
                <div class="text-section">
                    {{ $treatmentAdvised ?? '' }}
                </div>
            </div>
        </div>
            <div class="footer">
                <span class="next-visit">Next Visit: </span>
                <span class="underline next-visit-field">{{ $nextVisit ?? '' }}</span>
                <div class="disclaimer">(NOT VALID FOR COURT OF LAW)</div>
            </div>
        </div>
    </div>

</body>
</html>
