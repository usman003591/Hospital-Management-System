<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pathology Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .bg-img {
            position: fixed;
            right: 70;
            bottom: 0;
            width: 80%;
            height: 80%;
            background-image: url('{{ public_path('logo.png') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.1;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 1;
            /* padding: 30px; */
            margin: 30px 30px 10px 30px;
            /* border: 1px solid rgb(216, 215, 215); */
            height: 90%;
        }

        .header {
            padding: 10px 0px;
            margin: 0px 0px 0px 10px;
            /* background-color: cyan; */
            width: 42rem;
        }

        .red-line {
            background-color: #B40505;
            padding: 4px 0px;
            width: 100%;
        }

        .header td {
            vertical-align: bottom;
        }

        .header-text {
            opacity: 0.8;
            padding: 0 0 5px 5px;
        }

        .tables-section {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid rgb(216, 215, 215);
            /* background-color: wheat; */
            table-layout: fixed;
            height: 15%;
            padding-bottom: 10px;
        }

        .tab-sec-col {
            width: 30%;
            vertical-align: top;
        }

        .column-table {
            width: 100%;
            /* margin: 10px; */
            padding: 10px;
            border-collapse: collapse;
            /* background-color: yellow; */

        }

        .column-table td,
        .column-table th {
            padding: 5px;
            vertical-align: bottom;
            /* border: 1px solid black; */
        }

        .tab-1 td {
            padding: 0;
        }

        .mid-sec{
            padding-left: 30px;
            padding-top: 5px;
            padding-right: 30px;
            /* background-color: yellowgreen; */
            height: 93%;
            border-left: 1px solid rgb(216, 215, 215);
            border-right: 1px solid rgb(216, 215, 215);
        }

        .right-sec{
            text-align: right;
            padding-right: 10px;
            padding-top: 5px;
            /* background-color: yellowgreen; */
            height: 93%;
        }

        .right-sec-components{
            padding-bottom: 9px;
        }

        .qr-code {
            text-align: center;
            /* padding-top: 5px; */
            vertical-align: middle;
        }

        .qr-code img {
            height: 90px;
            width: auto;
            padding-left: 5px;
        }

        .report-details {
            width: 100%;
            font-size: 12pt;
            padding: 5px 10px 20px 10px;
            border-bottom: 1px solid rgb(216, 215, 215);
        }

        .report-details th,
        td {
            text-align: left;
            padding: 5px 0px;
        }

        #cbc {
            text-align: center;
            font-size: larger;
            padding: 10px 0px;
        }

        #main-cols {
            font-size: large
        }

        .footer-line {
            width: 100%;
            border-collapse: collapse;
            background-color: #0d47a1;
            margin-top: auto;
            margin-bottom: 0;
        }

        .left-side {
            /* background-color: #e91e63; */
            color: white;
            padding: 18px 30px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            width: 60%;
        }

        .right-side {
            color: white;
            padding: 18px 30px;
            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            width: 40%;
        }

          .reference-value-col {
                /* keeps the column a predictable width              */
                width: 230px;                 /* change to suit design */
                /* turns on full justification                       */
                text-align: justify;
                text-justify: inter-word;     /* better word spacing   */
                /* tidy extras                                        */
                line-height: 1.35;
                word-break: break-word;       /* avoids overflow       */
                padding: 6px 10px;
            }

            /* ★ Trick to justify the LAST line too ★ */
            .reference-value-col::after {
                content: "";                  /* invisible filler      */
                display: inline-block;
                width: 100%;
            }


    </style>
</head>

<body>
    <div class="bg-img"></div>
    <div class="content">
        <table class="header">
            <tr>
                <td>
                    <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}"
                        alt="HIMS" width="60">
                </td>
                <td class="header-text">
                    <h3>@isset($hospital->name) {{$hospital->name}} @endisset</h3>
                </td>
                <td width="80"></td>
                <td class="header-text" width="200">
                    <small>@isset($hospital->address) {{$hospital->address}} @endisset</small>
                </td>
            </tr>
        </table>
        <div class="red-line"></div>
        <div class="tables-section">
            <table>
                <tr>
                    <td class="tab-sec-col">
                        <div class="column-table tab-1">
                            <table>
                                <tr>
                                    <th style="padding-left: 0; text-align: left; font-size: large;" colspan="2">@isset($patient->name_of_patient) {{$patient->name_of_patient}} @endisset</th>
                                </tr>
                                <tr>
                                    <td>MR No: @isset($patient->patient_mr_number) {{$patient->patient_mr_number}} @endisset</td>
                                </tr>
                                <tr>
                                    <td>Age: @isset($patient->age) {{$patient->age}} @endisset Years</td>
                                    {{-- <td class="qr-code" rowspan="3">
                                        <img src="{{ public_path('/QR_code.png') }}" alt="QR Code">
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td>Gender: @isset($patient->gender) {{ucfirst($patient->gender)}} @endisset</td>
                                </tr>

                            </table>
                        </div>
                    </td>
                    <td class="tab-sec-col" style="width: 40%;">
                        <div class="mid-sec">
                                <h4>Sample Collected At: </h4>
                                <div style="height: 65%; padding-top: 5px;">
                                    <p>@isset($hospital->address) {{$hospital->address}} @endisset</p>
                                </div>
                                <div>
                                    <p>Ref. By: <strong>@isset($doctor->doctor_name) {{$doctor->doctor_name}} @else self @endisset</strong></p>
                                </div>
                        </div>
                    </td>
                    <td class="tab-sec-col" style="width: 25%;">
                        <div class="right-sec">
                            <div class="right-sec-components">
                                <h4>Registered on: </h4>
                                <p>@isset($patient->created_at)
                                    {{getDateInStandardFormat($patient->created_at)}}
                                @endisset</p>
                            </div>
                            @isset($obj->received_at)
                            <div class="right-sec-components">
                                <h4>Collected on: </h4>
                                <p>{{getDateInStandardFormat($obj->received_at)}}</p>
                            </div>
                            @endisset

                            <div class="right-sec-components">
                                <h4>Reported on:</h4>
                                <p>@isset($obj->report_date){{getDateInStandardFormat(Carbon\Carbon::parse($obj->report_date))}} @endisset</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="report-details">
            <thead>
                <tr>
                    <th colspan="4" id="cbc">@isset($investigation)
                     {{$investigation->name}}
                    @endisset</th>
                </tr>
            </thead>
            <tbody>

                <tr id="main-cols">
                    <th style="width: 20%;">Investigation</th>
                    <th style="width: 25%; text-align: center;">Result</th>
                    <th class="reference-value-col">Ref. Value</th>
                    <th style="width: 20%; text-align: center;">Unit</th>
                </tr>

                @isset($lab_test_data)
                @if (count($lab_test_data) > 0)
                @foreach ($lab_test_data as $d)
                <tr>
                    <td>@isset($d->name)
                     {{$d->name}}
                    @endisset</td>
                    <td style="text-align: center;">@isset($d->value)
                    @if ($d->mark_normal == 1)
                    {{$d->value}}
                    @else
                     <strong><u>{{$d->value}}</u></strong>
                    @endif
                    @endisset</td>
                    <td style="">@isset($d->reference_value)
                     {{$d->reference_value}}
                    @endisset</td>
                    <td style="text-align: center;">@isset($d->unit)
                     {{$d->unit}}
                    @endisset</td>
                </tr>
                @endforeach
                @endif
                @endisset



            </tbody>
        </table>

        {{-- <div class="arrow-left">fsdfasdf</div> --}}
    </div>
    <table class="footer-line">
        <tr>
            <td class="left-side">For More Services, Contact Us:</td>
            <td class="right-side">051 5579528, 0300 0560342</td>
        </tr>
    </table>
</body>

</html>
