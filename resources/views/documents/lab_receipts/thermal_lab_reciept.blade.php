<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>POS Receipt</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            font-weight: bold;
            margin: 0;
            padding: 0px;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .right {
            text-align: right;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 5px;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
        }

        .hms-logo {
            width: 100px;
            height: 100px;
            margin-left : 70px;
            text-align: center;
        }

        .header {
            font-size: 10px;
            border-top: 1px dotted #000;
            padding-top: 5px;
            margin-top: 0px;
        }
    </style>
</head>

<body>

    <header class="header">
        <img class="hms-logo" style="text-align: center !important"
            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo.png')))}}" alt="Logo">
        <div class="text-center title-section" style="margin-top: 15px;   text-align: center !important;">
            <h2 class="text-center"> {{$hospital->name}} <br> ({{$hospital->hospital_abbreviation}})</h2>
            <h2>Lab Invoice</h2>
        </div>
    </header>
    <hr>
    <div>
        <b style="margin: 3px">Invoice #: </b> {{ $invoice->invoice_sequence }}<br>
        <b style="margin: 3px">MR Number: </b> @isset($patient->patient_mr_number ) {{ $patient->patient_mr_number }} @else NA @endisset<br>
        <b style="margin: 3px">Patient: </b> @isset($patient->name_of_patient ) {{ $patient->name_of_patient }} @else NA @endisset<br>
        <b style="margin: 3px">Date: </b> {{ getDateInStandardFormat($invoice->date_issued) }}<br>
    </div>

    <hr>

    @php


    @endphp

    <table>
        <thead>
            <tr>
                <td>Sr.</td>
                <td class="width: 80px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; ">
                    <b>Investigation</b></td>
                <td class="right"><b>Total</b></td>
            </tr>
        </thead>
        <tbody>

        @php $count = 0 @endphp
        @foreach ($invoice_items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td> {{ $item->investigation_name }} </td>
            <td class="right">{{ sprintf('%g', $item->price) }}</td>
        </tr>
        @endforeach

        </tbody>
    </table>

    <hr>

    <table>
        <tr>
            <td><b>Subtotal</b></td>
            <td class="right">Rs. {{ $invoice->total_amount }}</td>
        </tr>
        <tr>
            <td><b>Discount Amount</b></td>
            <td class="right">@isset($invoice->discount_amount) {{$invoice->discount_amount}} @endisset</td>
        </tr>
        <tr class="total">
            <td><b>Grand Total</b></td>
            <td class="right">Rs. {{ $invoice->net_amount }}</td>
        </tr>
    </table>

    <hr>

    <div class="footer">
        Thank you for visiting<br>
    </div>

</body>

</html>
