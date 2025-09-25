<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Slip</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Times New Roman, serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            width: 210mm;
            height: 297mm;
        }

        .container {
            width: 190mm;
            margin: 0 auto;
            margin-top: 10px;
            padding: 3mm;
            box-sizing: border-box;
            border: 1px solid #000;
            height: 45%;
            /* Adjusted height to fit two copies */
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 6mm;
            position: relative;
        }

        .logo {
            width: 20mm;
            height: 20mm;
            margin-right: 5mm;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .title-section {
            flex-grow: 1;
            text-align: center;
        }

        .institute-name {
            font-size: 16px;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .slip-title {
            font-size: 14px;
            border: 1px solid #000;
            padding: 2px 10px;
            display: inline-block;
            margin: 0;
            font-weight: normal;
        }

        .date-section {
            position: absolute;
            top: 0;
            right: 0;
            margin-left: -20px;
            text-align: right;
        }

        .date-section div {
            margin-bottom: 5px;
        }

        .form-field {
            margin-bottom: 5mm;
            position: relative;
            overflow-wrap: break-word;
        }

        .form-field label {
            display: block;
            margin-bottom: 1mm;
            font-weight: bold;
        }

        .amount-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .amount-box {
            border: 1px solid #000;
            text-align: center;
            padding-top: 10px !important;
            width: 25mm;
            height: 8mm;
        }

        .signatures1 {
            display: flex;
            justify-content: space-between;
            margin-top: 20mm;
        }

        .signatures2 {
            display: flex;
            justify-content: space-between;
            margin-top: 20mm;
        }

        .signature-block {
            text-align: center;
            width: 45mm;
        }

        .signature-block.left {
            float: left;
            margin-left: 10mm;
        }

        .signature-block.right {
            float: right;
            margin-left: 10mm;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin-bottom: 2mm;
        }

        .signature-title {
            font-size: 11px;
            line-height: 1.4;
        }

        .divider {
            width: 100%;
            border: none;
            border-top: 1px dashed #000;
            margin: 2mm 0;
            position: relative;
        }

        .divider::after {
            content: "✂";
            position: absolute;
            right: -5mm;
            top: -3mm;
            font-size: 14px;
        }

        .input-text {
            border: none;
            width: 100%;
            outline: none;
            border-bottom: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- First copy content -->
        <div class="header">
            <div class="logo">
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->logo))) }}"
                    alt="Logo">
            </div>
            <div class="title-section">
                <h1 class="institute-name">{{ $hospital->name }} ({{ $hospital->hospital_abbreviation }})</h1>
                <h2 class="slip-title">Cash Deposit Slip</h2>
            </div>
            <div class="date-section">
                <div>Date: <input type="text" class="input-text" style="width: 100px;"
                        value="{{getBasicDateFormat($obj->date_issued, 'd-m-Y H:i') ?? ''}}"></div>
                <div>Slip No. <input type="text" class="input-text" style="width: 100px;"
                        value="{{ $obj->deposit_slip_number }}"></div>
            </div>
        </div>

        <div class="form-field">
            <label>Received From:</label>
            <input type="text" class="input-text" style="width: 50%;" value="{{ $user_data->name }}">
        </div>

        <div class="form-field">
            <label>Counter No.</label>
            <input type="text" class="input-text" style="width: 50%;" value="{{ $obj->counter_number }}">
        </div>

        <div class="form-field">
            <label>Amount in Rs:</label>
            <div class="amount-section">
                <input type="text" class="input-text" style="width: 50%;" value="{{ $obj->amount_in_words }}">
                <div style="float: right">
                    <label>Amount</label>
                    <div class="amount-box">{{ $obj->amount_in_figures }}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <label>Payment Purpose:</label>
            <input type="text" class="input-text" style="width: 50%;" value="{{ $obj->payment_purpose }}">
        </div>

        <div class="signatures1">
            <div class="signature-block left">
                <div class="signature-line"></div>
                <div class="signature-title">
                    Deposited By<br>
                    Receptionist/ Cashier
                </div>
            </div>
            <div class="signature-block right">
                <div class="signature-line"></div>
                <div class="signature-title">
                    Received By<br>
                    Accounts Manager
                </div>
            </div>
        </div>
    </div>

    <hr class="divider">

    <div class="container">
        <!-- Second copy content (identical to first) -->
        <div class="header">
            <div class="logo">
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->logo))) }}"
                    alt="Logo">
            </div>
            <div class="title-section">
                <h1 class="institute-name">{{ $hospital->name }} ({{ $hospital->hospital_abbreviation }})</h1>
                <h2 class="slip-title">Cash Deposit Slip</h2>
            </div>
            <div class="date-section">
                <div>Date: <input type="text" class="input-text" style="width: 100px;"
                        value="{{getBasicDateFormat($obj->date_issued, 'd-m-Y H:i') ?? ''}}"></div>
                <div>Slip No. <input type="text" class="input-text" style="width: 100px;"
                        value="{{ $obj->deposit_slip_number }}"></div>
            </div>
        </div>

        <div class="form-field">
            <label>Received From:</label>
            <input type="text" class="input-text" style="width: 50%;" value="{{ $user_data->name }}">
        </div>

        <div class="form-field">
            <label>Counter No.</label>
            <input type="text" class="input-text" style="width: 50%;" value="{{ $obj->counter_number }}">
        </div>

        <div class="form-field">
            <label>Amount in Rs:</label>
            <div class="amount-section">
                <input type="text" class="input-text" style="width: 50%;" value="{{ $obj->amount_in_words }}">
                <div style="float: right">
                    <label>Amount</label>
                    <div class="amount-box">{{ $obj->amount_in_figures }}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <label>Payment Purpose:</label>
            <input type="text" class="input-text" style="width: 50%;" value="{{ $obj->payment_purpose }}">
        </div>

        <div class="signatures2">
            <div class="signature-block left">
                <div class="signature-line"></div>
                <div class="signature-title">
                    Deposited By<br>
                    Receptionist/ Cashier
                </div>
            </div>
            <div class="signature-block right">
                <div class="signature-line"></div>
                <div class="signature-title">
                    Received By<br>
                    Accounts Manager
                </div>
            </div>
        </div>
    </div>
</body>

</html>
