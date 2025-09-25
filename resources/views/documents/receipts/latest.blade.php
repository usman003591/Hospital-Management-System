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

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            max-width: 100px;
            max-height: 100px;
            width: auto;
            height: auto;
        }

        .header .title {
            flex-grow: 1;
            text-align: center;
            padding: 0 10px;
            /* Add padding to create space between the logos and the text */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .totals {
            text-align: right;
            margin-top: 20px;
        }

        .totals div {
            margin-bottom: 5px;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
            }

            .container {
                width: 100%;
                max-width: none;
                padding: 0;
                margin: 0;
            }

            table,
            th,
            td {
                font-size: 12pt;
                page-break-inside: avoid;
            }

            .totals div {
                font-size: 12pt;
            }

            @page {
                size: A4;
                margin: 20mm;
            }
        }

        #underline-gap {
            text-decoration: underline;
            text-underline-position: under;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo.png')))}}"
                width="250px" alt="" style="margin-bottom: -100px !important">
            <div class="title">
                <h2 id="underline-gap"><strong>Smart Institute of Rehabilitation</strong></h2>
                <h2 id="underline-gap"><strong>Medicine (SIRM)</strong></h2>
                <h5><strong>CASH RECEIPT</strong></h5>
            </div>
            {{-- <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('samrtcitylogo.png')))}}"
                alt="" style="margin-left : 680px !important;  margin-top : -160px !important"> --}}
        </div>

        <div class="receipt-info" style="text-align: right;">
            <p>Receipt #: {{$obj->receipt_number}}</p>
        </div>

        <table>
            <tr>
                <td>Name:</td>
                <td>{{ucfirst($patient->name_of_patient)}}</td>
                <td>Age:</td>
                <td>{{$patient->age}}</td>
            </tr>
            <tr>
                <td>Category:</td>
                @php $patient_category=str_replace("_"," ",$patient->patient_category); @endphp
                <td>{{ucfirst($patient_category)}}</td>
                <td>Cell:</td>
                <td>{{$patient->cell}}</td>
            </tr>
            <tr>
                <td>MR NO:</td>
                <td colspan="3">{{$patient->patient_mr_number}}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Sr.</th>
                <th>Service Category</th>
                <th>Amount</th>
            </tr>
            @php $i = 0; @endphp
            @foreach ($invoice_services as $service)
            @php $i++ @endphp
            <tr>
                <td>{{$i}}</td>
                <td>{{$service->service_name}}</td>
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

        <div class="totals">
            @isset($obj->total_amount)
            <div>Total Amount: &nbsp;&nbsp; {{$obj->total_amount}}</div>
            @else
            <div>Total Amount: ____________</div>
            @endisset
            @isset($obj->discount_amount)
            @if ($obj->discount_amount > 0)
            <div>Discount: &nbsp;&nbsp; {{$obj->discount_amount}}</div>
            @endif
            @endisset
            @isset($obj->net_amount)
            @if ($obj->discount_amount > 0)
            <div style="margin-right: 100px !importantt"> Net Amount: &nbsp;&nbsp; &nbsp;&nbsp; {{$obj->net_amount}}
            </div>
            @else
            <div>Net Amount: &nbsp;&nbsp; {{$obj->net_amount}}</div>
            @endif
            @endisset
            @isset($obj->amount_received)

            @if ($obj->discount_amount > 0)
            <div style="margin-right: 100px !importantt">Amount Received: &nbsp;&nbsp; &nbsp;&nbsp;
                {{$obj->amount_received}}</div>
            @else
            <div>Amount Received: &nbsp;&nbsp; {{$obj->amount_received}}</div>
            @endif
            @endisset
        </div>

        {{-- @if ($special_employee_discount_status)
        <div style="font-weight: bold;
        font-size: 12px;">{{$employee_discount_message}}</div>
        @endif --}}

    </div>
</body>

</html>
