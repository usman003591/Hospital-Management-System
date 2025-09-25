<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Receipt</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            flex-wrap: wrap;
        }

        .container {
            width: 49%;
            padding: 15px;
            margin-left: -20px !important;
            border: 1px solid black;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header img {
            max-width: 70px;
            max-height: 70px;
        }

        .header .title {
            text-align: center;
            font-size: 12px !important;
        }

        .reciept-info {
            width: 100%;
            overflow: auto;
            font-size: 14px;
            padding-bottom: 15px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
        }

        .invoice-table-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        .invoice-table-details th,
        .invoice-table-details td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: left;
        }

        /* th,
        td {
            padding: 5px;
            text-align: center;
        } */

        .totals {
            width: 45%;
            text-align: left;
            margin-top: 10px;
            font-size: 10pt;
            margin-left: auto;
            margin-right: 0;
        }

        .totals td {
            margin: 3px;
        }

        .right-item {
            width: 45%;
            text-align: right;
        }

        .copy-type {
            margin-top: -20px !important;
            bottom: 10px;
            font-weight: bold;
            font-size: 12px;
        }

        #underline-gap {
            text-decoration: underline;
            text-underline-position: under;
        }

        .footer {
            font-size: 10px;
            border-top: 1px dotted #000;
            padding-top: 5px;
            margin-top: 15px;
            font-style: italic;
            text-align: center;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 10pt;
            }

            .page {
                display: flex;
                flex-direction: row;
                gap: 10px;
                justify-content: space-between;
                page-break-inside: avoid;
            }

            .container {
                width: 49%;
                padding: 10px;
                margin: 0;
                box-sizing: border-box;
            }

            table,
            th,
            td {
                font-size: 9pt;
                page-break-inside: avoid;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }
    </style>
</head>

<body>

    <div class="page" style="width:100%;">
        <!-- Receipt 1 -->
        <div class="container" style="float:left; width:46%;">
            <!-- Header Section -->
            <div class="header">
                <div style="text-align: center;">
                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->logo))) }}"
                        alt="Logo" style="max-height: 60px; display: block; margin: 0 auto;">
                </div>
                <div class="title">
                    <h2 id="underline-gap"><strong>{{$hospital->name}}</strong></h2>
                    <h2 id="underline-gap"><strong>({{$hospital->hospital_abbreviation}})</strong></h2>
                    <h5 style=""><strong>CASH RECEIPT</strong></h5>
                </div>
                {{-- <div style="margin-left : 380px !important; margin-top : -170px !important">&nbsp;</div> --}}
                {{-- src="{{ file_exists(public_path($hospital->project_logo)) ?
                'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->project_logo))) :
                'data:image/png;base64,' . base64_encode(file_get_contents(public_path('samrtcitylogo.png'))) }}" alt="Project Logo"
                --}}

                {{-- <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->project_logo)))}}"
                    alt="Logo" style="margin-left : 380px !important;  margin-top : -170px !important"> --}}
            </div>
            <div class="reciept-info">
                <p style="float: left; margin: 0;">Receipt #: {{ $obj->invoice_sequence }}</p>
                <p style="float: right; margin: 0;">{{ getBasicDateFormat($obj->date_issued, 'd-m-Y H:i') ?? '' }}</p>
            </div>
            {{-- <div class="receipt-info" style="text-align: right;">
            </div> --}}

            <!-- Patient Info Table -->
            <table class="invoice-table">
                <tr>
                    <td width="20%">Name</td>
                    <td colspan="3">{{ucfirst($patient->name_of_patient)}}</td>
                </tr>
                <tr>
                    <td width="20%">MR No</td>
                    <td>{{$patient->patient_mr_number}}</td>
                    <td>Age</td>
                    <td>{{$patient->age}}</td>
                </tr>
                <tr>
                    <td width="20%">Category</td>
                    <td>{{ucfirst(str_replace('_', ' ', $patient->patient_category))}}</td>
                    <td>Cell</td>
                    <td>{{$patient->cell}}</td>
                </tr>
            </table>

            <!-- Services Table -->
            <table class="invoice-table-details">
                <tr>
                    <th width="20%">Sr.</th>
                    <th width="60%">Service Category</th>
                    <th width="20%">Amount</th>
                </tr>
                @php $i = 0; @endphp
                @foreach ($invoice_services as $service)
                @php $i++ @endphp
                @php
                if(strlen($service->service_name) > 30) {
                $service_name = $service->parent_code.' ' . substr($service->service_name,0,35).'... ';
                } else {
                $service_name = $service->parent_code.' ' . $service->service_name;
                }
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$service_name}}</td>
                    <td>{{$service->price}}</td>
                </tr>
                @endforeach

                @isset($filldata_services )
                @for($i = 0; $i < $filldata_services; $i++) <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    @endfor
                    @endisset

            </table>

            <table class="totals">
                <tr>
                    <td>
                        Total Amount:</td>
                    <td class="right-item">&nbsp;{{$obj->total_amount ?? '_________'}}</td>
                </tr>
                <tr>
                    <td>
                        Discount:</td>
                    <td class="right-item">
                        &nbsp;{{$obj->discount_amount}}</td>
                </tr>
                <tr>
                    <td>
                        Net Amount:</td>
                    <td class="right-item">
                        &nbsp;{{$obj->net_amount ?? '_________'}}</td>
                </tr>
                <tr>
                    <td>Amount Received:</td>
                    <td class="right-item">&nbsp;{{$obj->amount_received ?? '_________'}}</td>
                </tr>
            </table>

            <div class="copy-type">PATIENT COPY</div>
            <div class="footer">
                {{-- Thank you for visiting...
                <br> --}}
                <p style="margin-top: 5px; margin-bottom: 0; padding-bottom: 0;">
                    This is system generated slip, no signature or stamp required
                </p>
            </div>
            {{-- @if ($special_employee_discount_status)
            <div style="font-weight: bold;
            margin-top :20px;
            font-size: 12px;">{{$employee_discount_message}}</div>
            @endif --}}
        </div>

        <!-- Receipt 2 (Copy) -->
        <div class="container" style="float:right; width:46%;">
            <!-- Header Section -->
            <div class="header">
                <div style="text-align: center;">
                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->logo))) }}"
                        alt="Logo" style="max-height: 60px; display: block; margin: 0 auto;">
                </div>
                <div class="title">
                    <h2 id="underline-gap"><strong>{{$hospital->name}}</strong></h2>
                    <h2 id="underline-gap"><strong>({{$hospital->hospital_abbreviation}})</strong></h2>
                    <h5 style=""><strong>CASH RECEIPT</strong></h5>
                </div>

            </div>

            <div class="reciept-info">
                <p style="float: left; margin: 0;">Receipt #: {{ $obj->invoice_sequence }}</p>
                <p style="float: right; margin: 0;">{{ getBasicDateFormat($obj->date_issued, 'd-m-Y H:i') ?? '' }}</p>
            </div>



            <!-- Patient Info Table -->
            <table class="invoice-table">
                <tr>
                    <td width="20%">Name</td>
                    <td colspan="3">{{ucfirst($patient->name_of_patient)}}</td>
                </tr>
                <tr>
                    <td width="20%">MR No</td>
                    <td>{{$patient->patient_mr_number}}</td>
                    <td>Age</td>
                    <td>{{$patient->age}}</td>
                </tr>
                <tr>
                    <td width="20%">Category</td>
                    <td>{{ucfirst(str_replace('_', ' ', $patient->patient_category))}}</td>
                    <td>Cell</td>
                    <td>{{$patient->cell}}</td>
                </tr>
            </table>

            <!-- Services Table -->
            <table class="invoice-table-details">
                <tr>
                    <th width="20%">Sr.</th>
                    <th width="60%">Service Category</th>
                    <th width="20%">Amount</th>
                </tr>
                @php $i = 0; @endphp
                @foreach ($invoice_services as $service)
                @php $i++ @endphp
                @php
                if(strlen($service->service_name) > 30) {
                $service_name = $service->parent_code.' ' . substr($service->service_name,0,35).'... ';
                } else {
                $service_name = $service->parent_code.' ' . $service->service_name;
                }
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$service_name}}</td>
                    <td>{{$service->price}}</td>
                </tr>
                @endforeach
                @isset($filldata_services )
                @for($i = 0; $i < $filldata_services; $i++) <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                    @endfor
                    @endisset

            </table>

            <table class="totals">
                <tr>
                    <td>
                        Total Amount:</td>
                    <td class="right-item">&nbsp;{{$obj->total_amount ?? '_________'}}</td>
                </tr>
                <tr>
                    <td>
                        Discount:</td>
                    <td class="right-item">
                        &nbsp;{{$obj->discount_amount}}</td>
                </tr>
                <tr>
                    <td>
                        Net Amount:</td>
                    <td class="right-item">
                        &nbsp;{{$obj->net_amount ?? '_________'}}</td>
                </tr>
                <tr>
                    <td>Amount Received:</td>
                    <td class="right-item">&nbsp;{{$obj->amount_received ?? '_________'}}</td>
                </tr>
            </table>

            <div class="copy-type">OFFICE COPY</div>
            {{-- @if ($special_employee_discount_status)
            <div style="font-weight: bold; margin-top :20px;
            font-size: 12px;">{{$employee_discount_message}}</div>
            @endif --}}
            <div class="footer">
                {{-- Thank you for visiting...
                <br> --}}
                <p style="margin-top: 5px; margin-bottom: 0; padding-bottom: 0;">
                    This is system generated slip, no signature or stamp required
                </p>
            </div>
        </div>

    </div>
</body>

</html>
