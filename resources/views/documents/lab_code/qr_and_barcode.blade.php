<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: 144pt 72pt;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 144pt;
            height: 72pt;
            overflow: hidden;
            font-family: sans-serif;
        }

        .label {
            width: 144pt;
            height: 72pt;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .barcode {
            text-align: center;
        }

        .barcode div {
            font-size: 7pt;
            font-weight: bold;
            margin-top: 1pt;
            line-height: 1;
        }

        .patient_details {
            font-size: 7pt;
            font-weight: bold;
            margin-top: 1pt;
            line-height: 1;
            padding-top: 6px;
            padding-right: 14px;
            padding-left: 14px;

        }

    </style>
</head>
<body>
    <div class="label">
        <div class="qr" style="padding-left: 130px; padding-top: 10px; margin-bottom : -27px;">
             <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($logo))) }}" alt="Hospital logo" width="32">
        </div>
        <div class="barcode" style="margin-top : 0px; padding-left: 15px; ">
            {!! DNS1D::getBarcodeHTML($barcodeText, 'C128', 0.9, 20) !!}
            <div style="padding-right : 70px">@isset($barcodeText) {{$barcodeText}} @endisset</div>
        </div>
        <div class="patient_details">
            <span class="mr-number">MR No : @isset($mr_number) {{$mr_number}} @endisset</span>
            <br>
            <span class="patient-name">Name : @isset($name) {{$name}} @endisset</span>
        </div>
    </div>
</body>
</html>
